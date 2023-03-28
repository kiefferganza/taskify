export const dateParser = (dateString) => {
    const parsedDate = new Date(dateString);
    const diff = parsedDate.getTime() - Date.now();
    const seconds = Math.floor(Math.abs(diff) / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const weeks = Math.floor(days / 7);
    const months = Math.floor(days / 30);
    const years = Math.floor(days / 365);

    if (diff > 0) {
        if (seconds < 60) {
            return 'just now';
        } else if (minutes < 60) {
            return `${minutes} minute${minutes > 1 ? 's' : ''} from now`;
        } else if (hours < 24) {
            return `${hours} hour${hours > 1 ? 's' : ''} from now`;
        } else if (days < 7) {
            return `${days} day${days > 1 ? 's' : ''} from now`;
        } else if (weeks < 4) {
            return `${weeks} week${weeks > 1 ? 's' : ''} from now`;
        } else if (months < 12) {
            return `${months} month${months > 1 ? 's' : ''} from now`;
        } else {
            return `${years} year${years > 1 ? 's' : ''} from now`;
        }
    } else {
        if (seconds < 60) {
            return 'just now';
        } else if (minutes < 60) {
            return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
        } else if (hours < 24) {
            return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        } else if (days < 7) {
            return `${days} day${days > 1 ? 's' : ''} ago`;
        } else if (weeks < 4) {
            return `${weeks} week${weeks > 1 ? 's' : ''} ago`;
        } else if (months < 12) {
            return `${months} month${months > 1 ? 's' : ''} ago`;
        } else {
            return `${years} year${years > 1 ? 's' : ''} ago`;
        }
    }
}
