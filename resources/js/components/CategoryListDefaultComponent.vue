<template>
  <div class="row">
    <div class="col-md-3" v-for="category in categories" :key="category.title">
      <div class="card mt-3">
        <router-link
          :to="{
            name: 'post-category',
            params: { category_id: category.id },
          }"
        >
          <img src="/images_category/php.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title text-center">{{ category.title }}</h5>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  created() {
    // console.log("created "+this.total);
    this.getCategories();
  },
  methods: {
    getCategories: function () {
      fetch("/api/category/all")
        .then((response) => {
          return response.json();
        })
        .then((json) => {
          this.categories = json.data;
        });
    },
  },
  data: function () {
    return {
      categories: {},
    };
  },
  watch: {
    currentPage: function (newVal, oldVal) {
      console.log(newVal);
      this.$emit("getCurrentPage", newVal);
    },
  },
};
</script>