<template lang="pug">
  div.comment-container
    comment-form
    div.line
    list-comment
</template>

<script>
  import CommentForm from './ComentForm'
  import ListComment from './List'
  import './comment.scss'

  export default {
    name: 'CommentIndex',
    components: {
      CommentForm,
      ListComment
    }
  }
</script>
