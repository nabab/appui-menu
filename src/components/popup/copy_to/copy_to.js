/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 25/10/18
 * Time: 18.20
 */
(()=>{
  return{
    props: ['source'],
    data(){
      return{
        destination: false
      }
    },
    methods:{
      onSuccess(d){
        if ( d.success ){
          appui.success(bbn._("Successfully copied menu!"));
        }
        else{
          appui.error(bbn._("Error copy!"));
        }
      }
    }
  }
})();
