<template>
  <div>
    <h1>{{category.title}}</h1>
    <post-list-default @getCurrentPage="getCurrentPage" v-if="total > 0" 
      :posts="posts" :total="total" :key="currentPage" 
      :pCurrentPage="currentPage"></post-list-default>
  </div>
</template>
<script>
export default {
  created() {
    this.getPosts();
  },
  methods: {
    postClick: function (p) {
      //console.log("click "+p.title);
      this.postSelected = p;
      //var myModal = new bootstrap.Modal(document.getElementById("postModal"), {});
      // setTimeout(function (){
      //myModal.show();
      // }, 1000);
    },
    getPosts() {
      console.log('___'+this.$route.params.category_id);
      fetch("/api/post/"+this.$route.params.category_id+"/category?page="+this.currentPage)
        .then(response => { return response.json() })
        .then(json => { 
          this.posts = json.data.posts.data;
          this.total = json.data.posts.last_page;
          this.category = json.data.category;
          });
      console.log("getPosts "+this.total);
    },
    getCurrentPage(currentPage){
      // console.log("PostList + currentPage: "+currentPage);
      this.currentPage = currentPage;
      this.getPosts();
    }
  },
  data: function () {
    return {
      postSelected: "",
      posts: [],
      category: "",
      total: 0,
      currentPage: 1
    };
  },
};
</script>