//Year Selector--------------------------------------------------------------------
function filterSelection(category, selectedCategory) {
    let elements = document.getElementsByClassName("content");
    if (category == "all") {
        category = "";
    }
    for (let i = 0; i < elements.length; i++) {
        let categories = elements[i].getAttribute("data-category");
        if (categories.indexOf(category) > -1) {
            elements[i].classList.add("active");
        } else {
            elements[i].classList.remove("active");
        }
    }
    let categories = document.getElementsByClassName("category");
    console.log(categories);
    for (let i = 0; i < categories.length; i++) {
        if (categories[i] == selectedCategory) {
            categories[i].classList.add("active");
        } else {
            categories[i].classList.remove("active");
        }
    }
}
//Search Function---------------------------------------------------------------------
const searchButton = document.querySelector(".searchButton");
const searchTerm = document.querySelector(".searchTerm");

// Add event listener for search button
searchButton.addEventListener("click", () => {
    const query = searchTerm.value;
    searchActiveContent("content", query);
});

searchTerm.addEventListener("keydown", (event) => {
    if (event.keyCode === 13) {
        const query = searchTerm.value;
        searchActiveContent("content", query);
    }
});

function searchActiveContent(className, searchTerm) {
    const activeElements = document.querySelectorAll(`.${className}`);

    for (const activeElement of activeElements) {
        const contentElements1 = Array.from(activeElement.querySelectorAll(".card-title"));
        const contentElements2 = Array.from(activeElement.querySelectorAll(".card-author"));
        const contentElements3 = Array.from(activeElement.querySelectorAll(".card-genres"));
        const contentElements4 = Array.from(activeElement.querySelectorAll(".card-book-isbn"));
        const matchingContentElement1 = contentElements1.find((element) => element.textContent.toLowerCase().includes(searchTerm.toLowerCase()));
        const matchingContentElement2 = contentElements2.find((element) => element.textContent.toLowerCase().includes(searchTerm.toLowerCase()));
        const matchingContentElement3 = contentElements3.find((element) => element.textContent.toLowerCase().includes(searchTerm.toLowerCase()));
        const matchingContentElement4 = contentElements4.find((element) => element.textContent.toLowerCase().includes(searchTerm.toLowerCase()));
        if (matchingContentElement1 || matchingContentElement2 || matchingContentElement3) {
            console.log("yes");
            activeElement.classList.remove("active");
            activeElement.classList.add("active");
        } else {
            console.log("no");
            activeElement.classList.remove("active");
        }
    }
}
