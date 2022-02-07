function setActiveNavButton(element) {
    const nav = document.getElementById("headerNav");
    const buttonsNav = nav.getElementsByTagName("button");
    for (const button of buttonsNav) {
        button.setAttribute('class', 'btn btn-secondary me-1');
    }
    element.setAttribute('class', 'btn btn-primary me-1');
}

function enableLoadSpinner() {
    const articleArea = document.getElementById('articleArea');
    articleArea.innerHTML +=
        '<div id="loadSpinner" class="d-flex justify-content-center h-50">\n' +
        '   <div class="spinner-border mt-auto"></div>\n' +
        '</div>'
}

function disableLoadSpinner() {
    const spinner = document.getElementById("loadSpinner");
    spinner.remove();
}

function getBlogs(element) {
    let blogsHeaderHTML = "<div class=\"d-flex flex-row bg-light border-bottom px-3 py-1\">\n" +
        "                <div class=\"me-auto\">Name</div>\n" +
        "                <div style=\"min-width: 124px\">Category</div>\n" +
        "                <div style=\"min-width: 124px\">Rating</div>\n" +
        "                <div style=\"min-width: 124px\">Subscribers</div>\n" +
        "            </div>\n";

    setActiveNavButton(element);
    const request = new XMLHttpRequest();
    const articleArea = document.getElementById('articleArea');
    articleArea.innerHTML = blogsHeaderHTML;
    enableLoadSpinner()
    request.onload = function () {
        disableLoadSpinner();
        articleArea.innerHTML += parseJsonBlogsIntoHTML(this.responseText);
    }
    request.open('GET', 'http://localhost:81/blog', true);
    request.send();
}

function getCategories(element) {
    let categoryHeaderHTML = "<div class=\"d-flex flex-row bg-light border-bottom px-3 py-1\">\n" +
        "                <div class=\"me-auto\">Name</div>\n" +
        "                <div style=\"min-width: 124px\">Rating</div>\n" +
        "                <div style=\"min-width: 124px\">Subscribers</div>\n" +
        "            </div>\n";

    setActiveNavButton(element);
    const request = new XMLHttpRequest();
    const articleArea = document.getElementById('articleArea');
    articleArea.innerHTML = categoryHeaderHTML;
    enableLoadSpinner()
    request.onload = function () {
        disableLoadSpinner();
        articleArea.innerHTML += parseJsonCategoriesIntoHTML(this.responseText);
    }
    request.open('GET', 'http://localhost:81/category', true);
    request.send();
}

function setHomePage(element) {
    setActiveNavButton(element);
    let homePageHTML = "<div class=\"bg-light p-3\">\n" +
        "                <h4>Home Page</h4>\n" +
        "                <p>It is a home page</p>\n" +
        "            </div>";
    const articleArea = document.getElementById('articleArea');
    articleArea.innerHTML = homePageHTML;
}

function parseJsonBlogsIntoHTML(json) {
    let result = "<div>";
    let blogs = JSON.parse(json);
    blogs.forEach(blogJson => {
        result += "<div class=\"d-flex flex-row bg-light border-bottom px-3 py-1\">\n" +
            "                <div class=\"d-flex flex-row me-auto\">\n" +
            "                    <div class=\"mt-2\">" +
            "                       <object data=\"svg/blog-solid.svg\" height=\"20\" width=\"20\" ></object>\n" +
            "                    </div>" +
            "                    <div class=\"ms-3\">\n" +
            "                        <a href=\"#\" class=\"link-primary text-decoration-none text-black\">" + blogJson.name + "</a>\n" +
            "                        <div class=\"text-muted\">" + blogJson.alias + "</div>\n" +
            "                    </div>\n" +
            "                </div>\n" +
            "                <div class=\"text-muted\" style=\"min-width: 124px\">" + blogJson.category.name + "</div>\n" +
            "                <div class=\"text-muted\" style=\"min-width: 124px\">Soon</div>\n" +
            "                <div class=\"text-muted\" style=\"min-width: 124px\">Soon</div>\n" +
            "            </div>"
    })
    result += "</div>";
    return result;
}

function parseJsonCategoriesIntoHTML(json) {
    let result = "<div>";
    let categories = JSON.parse(json);
    categories.forEach(categoryJson => {
        result += "<div class=\"d-flex flex-row bg-light border-bottom px-3 py-1\">\n" +
            "                <div class=\"d-flex flex-row me-auto\">\n" +
            "                    <div class=\"mt-2\">" +
            "                       <object data=\"svg/arrow-alt-circle-right-regular.svg\" height=\"20\" width=\"20\" ></object>\n" +
            "                    </div>" +
            "                    <div class=\"ms-3\">\n" +
            "                        <a href=\"#\" class=\"link-primary text-decoration-none text-black\">" + categoryJson.name + "</a>\n" +
            "                    </div>\n" +
            "                </div>\n" +
            "                <div class=\"text-muted\" style=\"min-width: 124px\">" + "Soon" + "</div>\n" +
            "                <div class=\"text-muted\" style=\"min-width: 124px\">Soon</div>\n" +
            "            </div>"
    })
    result += "</div>";
    return result;
}