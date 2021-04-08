import cs from "./console"

export default {
  methods: {
    mFollow(user){
      user.followedUser++
      user.follow = true
      axios.post('/api/follow', {
        followedUserId: user.id,
        followingUserId: this.$store.state.auth.userId
      })
      .then(res => {
        return user
      })
      .catch(err => {
        cs.methods.showConsoleLog(err)
        user.follow = false
        user.followedUser--
        return user
      })
    },
    mUnfollow(user){
      user.follow = false
      user.followedUser--
      axios.post('/api/unfollow', {
        followedUserId: user.id,
        followingUserId: this.$store.state.auth.userId
      })
      .then(res => {
        return user
      })
      .catch(err => {
        cs.methods.showConsoleLog(err)
        user.follow = true
        user.followedUser++
        return user
      })
    },
  }
}