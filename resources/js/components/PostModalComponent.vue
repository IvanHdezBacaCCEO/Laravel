<template>
  <div>
    <div
      class="modal fade"
      id="postModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ post.title }}</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">{{ post.content }}</div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["post"],
  mounted() {
    console.log("modal created");
    var myModal = new bootstrap.Modal(document.getElementById("postModal"), {});

    // setTimeout(function (){
    //     myModal.show();
    // }, 1000);
  },
  watch: {
    post: function (newVal, oldVal) {
      // console.log("post-watch-new " + newVal.title + '\n'+"post-watch-old " + oldVal.title);
      // console.log();
      var myModal = new bootstrap.Modal(
        document.getElementById("postModal"),
        {}
      );
      myModal.show();
    },
  },
};
</script>