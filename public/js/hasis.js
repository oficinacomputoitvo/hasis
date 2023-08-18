function preview(event, divDestination) {
    for (let file of event.target.files) {
        let src = URL.createObjectURL(file);
        let iframe = document.createElement("iframe");
        iframe.src = src;
        var destination = document.getElementById(divDestination);
        if (destination.hasChildNodes()) {
            destination.removeChild(destination.firstElementChild);
        }
        destination.appendChild(iframe);
        destination.style.display = "block";
        destination.style.visibility = true;
    }
}

const validateSize = (fileId, maxSize) => {
    let size = document.getElementById(fileId).files[0].size;
    console.log("SIZE:" + size);
    return size <= maxSize;
};

const validateType = (fileId, ...fileTypes) => {
    const NOT_FOUND = -1;
    let type = document.getElementById(fileId).files[0].type;
    const upperCased = fileTypes.map((it) => it.toUpperCase());
    const isFound = upperCased.indexOf(type.toUpperCase()) !== NOT_FOUND;
    return isFound;
};

function currentDate(){
    const date = new Date();
    const day = date.getDate().toString().padStart(2,"0");
    const month = (date.getMonth() + 1).toString().padStart(2,"0");
    const year = date.getFullYear();
    return (`${year}-${month}-${day}`);
}
