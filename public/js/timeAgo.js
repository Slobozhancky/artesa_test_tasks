function timeAgo(unixTime) {
    const now = Date.now();
    const diff = now - unixTime * 1000;

    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (minutes < 5) {
        return "just now";
    } else if (minutes < 60) {
        return `${minutes} minutes ago`;
    } else if (hours < 8) {
        const roundedMinutes = Math.round((minutes % 60) / 5) * 5;
        return `${hours} hours ${roundedMinutes} minutes ago`;
    } else if (hours < 24) {
        const roundedHours = Math.round(hours + minutes / 60);
        return `${roundedHours} hours ago`;
    } else if (days < 30) {
        return `${days} days ago`;
    } else {
        const date = new Date(unixTime * 1000);
        const day = date.getDate().toString().padStart(2, "0");
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const year = date.getFullYear();
        return `${day}.${month}.${year}`;
    }
}

console.log(timeAgo(1698585000));