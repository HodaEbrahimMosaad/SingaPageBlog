<template>
    <div>
        <h2>Articles</h2>
        <form v-on:submit="addArticle" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="article.title">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Body" v-model="article.body"></textarea>
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <button  class="btn btn-danger btn-block">Cancel</button>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li :class="{ disabled : !pagination.prev}"  class="page-item"><a class="page-link" href="#" v-on:click="fetchArticles(pagination.prev)" >Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li :class="{ disabled : !pagination.next}"  class="page-item"><a class="page-link" href="#"  v-on:click="fetchArticles(pagination.next)">Next</a></li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="article in articles">
            <h3>{{ article.title }}</h3>
            <p>{{ article.body }}</p>
            <hr>
            <button v-on:click="deleteArticle(article.id)" class="btn btn-danger mb-2">Delete</button>
            <button v-on:click="editArticle(article)" class="btn btn-warning">Edit</button>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default
    {
        data() {
            return {
                articles: [],
                article: {
                    id: '',
                    title: '',
                    body: ''
                },
                article_id: '',
                pagination: {},
                edit: false
            };
        },
        created() {
            this.fetchArticles();
        },
        methods: {
            fetchArticles(page_url) {
                page_url = page_url || 'http://localhost/lar/larticles/public/api/articles' ;

                axios.get(page_url).
                then(res => {
                    console.log(res.data)
                    this.articles = res.data.data;
                    this.pagination.next = res.data.links.next;
                    this.pagination.prev = res.data.links.prev;
                    this.pagination.current_page = res.data.meta.current_page;
                    this.pagination.last_page = res.data.meta.last_page;

                }).
                catch(err => console.log(err));
            },
            deleteArticle: function (id) {
                if(confirm("Are you sure?")){
                    axios.delete(`api/article/${id}`).
                    then(res => {
                        alert("Article Removed");
                        console.log(res);
                        this.fetchArticles();
                    }).
                    catch(err => console.log(err));
                }

            },
            addArticle: function (e) {
                if (!this.edit) {
                    e.preventDefault();
                    var article = this.article;
                    axios.post(`api/article`, article).then(res => {
                        alert("Article added");
                        console.log(res);
                        this.fetchArticles();
                        this.clearForm();
                    }).catch(err => console.log(err));
                } else {
                    axios.put(`api/article/${this.article.id}`, this.article).
                    then(res => {
                        alert("Article updated");
                        console.log(res);
                        this.fetchArticles();
                        this.clearForm();
                    }).
                    catch(err => console.log(err));
                }
            },
            clearForm: function () {
                this.article.title= "";
                this.article.body= "";
            },
            editArticle: function (article) {
                this.article = article;
                this.edit = true;
            }




        }
    }

</script>


<!--

props: {
            msg: {
              type:String,
              default: "somaia"
          }
        },
        data() {
            return {
                name: "hoda",
                users: [
                    {fname: "hoda", lname:"mosaad"},
                    {fname: "somaia", lname:"mosaad"},
                ]
            }
        },
        computed: {
            fullName: function () {
                return this.users[0].fname + " " + this.users[0].lname;
            }
        },
        methods: {
            up: function (e) {
                console.log(e.target.value)
            },
            upenter: function () {
                console.log("enter pressed")
            }
        }


-->