<bbn-form :source= "source"
          :action="root + 'actions/menu/rename' "
          @success="onSuccess"
>
  <div class="bbn-padding bbn-w-100">
    <bbn-input class="bbn-w-100"
               v-model="source.text"
               required="required"
    ></bbn-input>
  </div>
</bbn-form>
