const articleTemplate = {
    template: '<div class="bg-light p-3">\n' +
        '                    <div>\n' +
        '                        <div class="d-flex flex-row">\n' +
        '                            <div class="me-1">\n' +
        '                                <object data="svg/address-card-solid.svg" height="20" width="20"></object>\n' +
        '                            </div>\n' +
        `                            <div>{{authorFirstName}} {{authorLastName}}</div>\n` +
        `                            <div class="text-muted ms-1">{{time}}</div>\n` +
        '                        </div>\n' +
        `                        <p><h3>{{title}}</h3></p>\n` +
        '                    </div>\n' +
        `                    <div>{{content}}</div>\n` +
        '                    <div class="d-flex flex-row border-top pt-2">\n' +
        '                        <button class="btn btn-primary d-flex">\n' +
        '                            <object data="svg/heart-solid.svg" height="20" width="20"></object>\n' +
        '                            <div class="ms-1">Like me</div>\n' +
        '                        </button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div id="comments" class="bg-light p-3 mt-2">\n' +
        '                    <div class="border-bottom mb-2">\n' +
        '                        <p>3 Comments</p>\n' +
        '                    </div>' +
        '                </div>'
}

const blogsTemplate = {
    template: '<div class="d-flex flex-row bg-light border-bottom px-3 py-1">\n' +
        '                <div class="me-auto">Name</div>\n' +
        '                <div style="min-width: 124px">Category</div>\n' +
        '                <div style="min-width: 124px">Rating</div>\n' +
        '               <div style="min-width: 124px">Subscribers</div>\n' +
        '            </div>\n' +
        '<div v-for="blog in blogs" class="d-flex flex-row bg-light border-bottom px-3 py-1">\n' +
        '    <div class="d-flex flex-row me-auto">\n' +
        '        <div class="mt-2">\n' +
        '            <object data="svg/blog-solid.svg" height="20" width="20"></object>\n' +
        '        </div>\n' +
        '        <div class="ms-3">\n' +
        '            <a class="link-primary text-decoration-none text-black" href="#">{{blog.name}}</a>\n' +
        '            <div class="text-muted">{{blog.alias}}</div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '\n' +
        '    <div class="text-muted" style="min-width: 124px">{{blog.category.name}}</div>\n' +
        '    <div class="text-muted" style="min-width: 124px">Soon</div>\n' +
        '    <div class="text-muted" style="min-width: 124px">Soon</div>\n' +
        '</div>'
}

const articlesTemplate = {
    template: '<div class="d-flex flex-row bg-light border-bottom px-3 py-1">\n' +
        '    <div class="me-auto">Name</div>\n' +
        '    <div style="min-width: 124px">Rating</div>\n' +
        '    <div style="min-width: 124px">Blog</div>\n' +
        '</div>\n' +
        '<div class="d-flex flex-row bg-light border-bottom px-3 py-1" v-for="article in articles">\n' +
        '    <div class="d-flex flex-row me-auto">\n' +
        '        <div class="mt-2">\n' +
        '            <object data="svg/newspaper-solid.svg" height="20" width="20"></object>\n' +
        '        </div>\n' +
        '        <div class="ms-3">\n' +
        '            <a class="link-primary text-decoration-none text-black" href="#"> {{article.title}} </a>\n' +
        '            <div class="text-muted"> {{article.author.firstName}} {{article.author.lastName}}</div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    <div class="text-muted" style="min-width: 124px">Soon</div>\n' +
        '    <div class="text-muted" style="min-width: 124px">Soon</div>\n' +
        '</div>'
}

const categoriesTemplate = {
    template: '<div class="d-flex flex-row bg-light border-bottom px-3 py-1">\n' +
        '    <div class="me-auto">Name</div>\n' +
        '    <div style="min-width: 124px">Rating</div>\n' +
        '    <div style="min-width: 124px">Subscribers</div>\n' +
        '</div>\n' +
        '<div class="d-flex flex-row bg-light border-bottom px-3 py-1" v-for="category in categories">\n' +
        '    <div class="d-flex flex-row me-auto">\n' +
        '        <div class="mt-2">\n' +
        '            <object data="svg/arrow-alt-circle-right-regular.svg" height="20" width="20"></object>\n' +
        '        </div>\n' +
        '        <div class="ms-3">\n' +
        '            <a class="link-primary text-decoration-none text-black" href="#">{{category.name}}</a>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '    <div class="text-muted" style="min-width: 124px">Soon</div>\n' +
        '    <div class="text-muted" style="min-width: 124px">Soon</div>\n' +
        '</div>'
}

const homeTemplate = {
    template: '<div class="bg-light p-3">\n' +
        '                <h4>Home Page</h4>\n' +
        '                <p>It is a home page!</p>\n' +
        '      </div>'
}