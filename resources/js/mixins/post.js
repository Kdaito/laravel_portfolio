import cs from "./console"

export default {
  methods: {
    mFavorite(post) {
      post.hasFavorite = true
      post.heartCount++
      axios.post('/api/posts/favorites', {
        postId: post.id,
        userId: this.$store.state.auth.userId,
      })
      .then(res => {
        return post
      })
      .catch(err => {
        cs.methods.showConsoleLog(err)
        post.hasFavorite = false
        post.heartCount--
        return post
      })
    },
    mUnfavorite(post) {
      post.hasFavorite = false
      post.heartCount--
      axios.post('/api/posts/unfavorites', {
        postId: post.id,
        userId: this.$store.state.auth.userId,
      })
      .then(res => {
        return post
      })
      .catch(err => {
        cs.methods.showConsoleLog(err)
        post.hasFavorite = true
        post.heartCount++
        return post
      })
    },
    convertCreatedAt(created) {
      const c = created.split(' ')[0].split('-')
      return `${c[0]}年${c[1]}月${c[2]}日`
    }
  }
}