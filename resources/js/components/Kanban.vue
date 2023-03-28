<template>
  <div class="drag-container">
    <ul class="drag-list">
      <li v-for="(stage, i) in stages" class="drag-column" :class="{['drag-column-' + stage]: true}" :key="stage">
        <span
          :class="stagesColors(i)"
          class="drag-column-header text-white rounded-lg shadow">
          <slot :name="stage">
            <h2>{{ stage }}</h2>
          </slot>
        </span>
        <div class="drag-options"></div>
        <ul class="drag-inner-list" ref="list" :data-status="stage">
          <li class="drag-item bg-white text-black rounded-lg shadow" v-for="block in getBlocks(stage)" :data-block-id="block[idProp]" :key="block[idProp]">
            <slot :name="block[idProp]">

              <h5 class="mb-2 text-2xl font-bold tracking-tight">{{block.title}}</h5>
              <p class="font-normal text-gray-700">{{block.description}}</p>
            </slot>
          </li>
        </ul>
        <div class="drag-column-footer">
          <slot :name="`footer-${stage}`"></slot>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import dragula from 'dragula';
import { Machine } from 'xstate';
export default {
  name: 'KanbanBoard',
  props: {
    stages: {
      type: Array,
      required: true,
    },
    blocks: {
      type: Array,
      required: true,
    },
    config: {
      type: Object,
      default: () => ({}),
    },
    stateMachineConfig: {
      type: Object,
      default: null,
    },
    idProp: {
      type: String,
      default: 'id',
    },
    statusProp: {
      type: String,
      default: 'status',
    },
  },
  data() {
    return {
      machine: null,
    };
  },
  computed: {
    localBlocks() {
      return this.blocks;
    },
  },
  methods: {
    stagesColors(index) {
      let color = '';
      switch(index) {
        case 1:
          color = 'bg-blue-500';
          break;
        case 2:
          color = 'bg-green-500';
          break;
        default:
          color = 'bg-yellow-500';
      }
      console.log(index, color)
     return color
    },
    getBlocks(status) {
      return this.localBlocks.filter(block => block[this.statusProp] === status);
    },
    findPossibleTransitions(sourceState) {
      return this.machine.config.states[sourceState].on || {};
    },
    findTransition(target, source) {
      const targetState = target.dataset.status;
      const sourceState = source.dataset.status;
      const possibleTransitions = this.findPossibleTransitions(sourceState);
      return Object.keys(possibleTransitions)
        .find(transition => possibleTransitions[transition] === targetState);
    },
    accepts(block, target, source) {
      if (!this.machine) return true;
      const targetState = target.dataset.status;
      const sourceState = source.dataset.status;
      return Object.values(this.findPossibleTransitions(sourceState)).includes(targetState);
    },
    allowedTargets(el, source) {
      const block = this.localBlocks.find(b => b[this.idProp] === el.dataset.blockId);
      return this.drake.containers.filter(c => this.config.accepts(block, c, source));
    },
    forbiddenTargets(el, source) {
      return this.drake.containers.filter(c => !this.allowedTargets(el, source).includes(c));
    },
  },
  updated() {
    this.drake.containers = this.$refs.list;
    this.drake.mirrorContainer = this.$el;
  },
  mounted() {
    this.config.accepts = this.config.accepts || this.accepts;
    this.config.mirrorContainer = this.$el;
    this.drake = dragula(this.$refs.list, this.config)
      .on('drag', (el, source) => {
        this.$emit('drag', el, source);
        el.classList.add('is-moving');
        this.allowedTargets(el, source).forEach(c => c.classList.add('allowed'));
        this.forbiddenTargets(el, source).forEach(c => c.classList.add('forbidden'));
      })
      .on('dragend', (el) => {
        this.$emit('dragend', el);
        el.classList.remove('is-moving');
        this.drake.containers.forEach(c => c.classList.remove('allowed', 'forbidden'));
        window.setTimeout(() => {
          el.classList.add('is-moved');
          window.setTimeout(() => {
            el.classList.remove('is-moved');
          }, 600);
        }, 100);
      })
      .on('drop', (block, list, source, sibling) => {
        this.$emit('drop', block, list, source, sibling);
        let index = 0;
        for (index = 0; index < list.children.length; index += 1) {
          if (list.children[index].classList.contains('is-moving')) break;
        }
        let newState = list.dataset.status;
        if (this.machine) {
          const transition = this.findTransition(list, source);
          if (!transition) return;
          newState = this.machine.transition(source.dataset.status, transition).value;
        }
        this.$emit('update-block', block.dataset.blockId, newState, index);
      })
      .on('cancel', (el, container, source) => {
        this.$emit('cancel', el, container, source);
      })
      .on('remove', (el, container, source) => {
        this.$emit('remove', el, container, source);
      })
      .on('shadow', (el, container, source) => {
        this.$emit('shadow', el, container, source);
      })
      .on('over', (el, container, source) => {
        this.$emit('over', el, container, source);
      })
      .on('out', (el, container, source) => {
        this.$emit('out', el, container, source);
      })
      .on('cloned', (clone, original, type) => {
        this.$emit('cloned', clone, original, type);
      });
    this.$emit('init', this.drake);
  },
  created() {
    if (!this.stateMachineConfig) return;
    this.machine = Machine(this.stateMachineConfig);
  },
};
</script>
<style>
ul.drag-list, ul.drag-inner-list {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.drag-container {
  max-width: 1000px;
  margin: 20px auto;
}

.drag-list {
  display: flex;
  align-items: flex-start;
}
@media (max-width: 690px) {
  .drag-list {
    display: block;
  }
}

.drag-column {
  flex: 1;
  margin: 0 10px;
  position: relative;
  overflow: hidden;
}
@media (max-width: 690px) {
  .drag-column {
    margin-bottom: 30px;
  }
}
.drag-column h2 {
  font-size: 0.8rem;
  margin: 0;
  text-transform: uppercase;
  font-weight: 600;
}

.drag-column-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
}

.drag-inner-list {
  min-height: 50px;
  color: white;
}

.drag-item {
  padding: 10px;
  margin: 10px;
  height: 100px;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}
.drag-item.is-moving {
  transform: scale(1.5);
  background: rgba(0, 0, 0, 0.8);
}

.drag-header-more {
  cursor: pointer;
}

.drag-options {
  position: absolute;
  top: 44px;
  left: 0;
  width: 100%;
  height: 100%;
  padding: 10px;
  transform: translateX(100%);
  opacity: 0;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
}
.drag-options.active {
  transform: translateX(0);
  opacity: 1;
}
.drag-options-label {
  display: block;
  margin: 0 0 5px 0;
}
.drag-options-label input {
  opacity: 0.6;
}
.drag-options-label span {
  display: inline-block;
  font-size: 0.9rem;
  font-weight: 400;
  margin-left: 5px;
}

/* Dragula CSS  */
.gu-mirror {
  position: fixed !important;
  margin: 0 !important;
  z-index: 9999 !important;
  opacity: 0.8;
  list-style-type: none;
}

.gu-hide {
  display: none !important;
}

.gu-unselectable {
  -webkit-user-select: none !important;
  -moz-user-select: none !important;
  -ms-user-select: none !important;
  user-select: none !important;
}

.gu-transit {
  opacity: 0.2;
}
</style>
