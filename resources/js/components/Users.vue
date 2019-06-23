<template>
        <div>
        <h1>
            Users
        </h1>
        <form v-on:submit="addNewUser">
            <input placeholder="name" v-model="addUser.name"/><br>
            <input placeholder="email" v-model="addUser.email"/><br>
            <input type="submit" />
        </form>
        <ul>
            <li v-for="user in users">
                <input type="checkbox" v-model="user.contacted"/>
                <span :class="{contacted: user.contacted}">
                    {{ user.name }} : {{ user.email }}
                </span>
                <button v-on:click="deleteUser(user)" >X</button>
            </li>
        </ul>
        </div>
</template>

<script>
    import axios from "axios";

    export default {
        data(){
            return {
                addUser: {
                  name: '',
                  email: '',
                  contacted: ''
                },
                page_url: '',
                users: [
                    {name: "hoda mosaad", email: "hodamosaad@gmail.com", contacted: false},
                    {name: "somaia mosaad", email: "somaia@gmail.com", contacted: false},
                    {name: "sara mosaad", email: "sara@gmail.com", contacted: false},
                ]
            }
        },
        created() {
            // this.$http.get('https://jsonplaceholder.typicode.com/users').then(function(response){
            //     console.log(response)
            // })
            axios.get('https://jsonplaceholder.typicode.com/users').
            then(res => {
                console.log(res)
                this.users = res.data;
            }).
            catch(err => console.log(err));

            // let page_url = 'https://jsonplaceholder.typicode.com/users'
            // fetch(page_url).
            //  then(res => res.json()).
            // then(res => {
            //     this.users = res;
            // }).
            // catch(err => console.log(err));
        },
        methods: {
            addNewUser: function (e) {
                this.users.push({
                    name: this.addUser.name,
                    email: this.addUser.email,
                    contacted: false
                });
                e.preventDefault();
            },
            deleteUser: function (user) {
                this.users.splice(this.users.indexOf(user), 1);
            },
            fechUsers: function(){

            }
        },

    }
</script>
<style scoped>
    .contacted{
        text-decoration: line-through;
    }
</style>