(function(){
	return {
    data(){
      return {root: this.source.root}
    },
    methods: {
      transform(a){
        return {
          data: a,
          id: a.id,
          icon: a.icon,
          code: a.code,
          text: a.text
        }
      }
    }
  }
})();