export default {
  methods: {
    showConsoleLog(value){
      if(process.env.MIX_APP_ENV === "local"){
        console.log(value)
      }
    }
  }
}