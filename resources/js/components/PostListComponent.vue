<template>
  <div>
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
      fetch("/api/post?page="+this.currentPage)
        .then(response => { return response.json() })
        .then(json => { 
          this.posts = json.data.data;
          this.total = json.data.last_page;
      console.log("getPosts "+this.total);
          });
      // fetch('/api/post')
      //   .then(function(response){
      //     return response.json();
      //   })
      //   .then(function(json){
      //     // console.log(json.data);
      //     this.posts = json.data.data;
      //   });
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
      total: 0,
      currentPage: 1
    };
  },
};
</script>