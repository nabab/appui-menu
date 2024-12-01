<bbn-form class="bbn-c"
          :source="formSource"
          :action="root + 'actions/menu/copy'"
          @success="onSuccess"
>
  <div class="bbn-padding bbn-w-100">
    <bbn-input class="bbn-w-100"
               v-model="formSource.title"
               required="required"
    ></bbn-input>
  </div>
</bbn-form>
