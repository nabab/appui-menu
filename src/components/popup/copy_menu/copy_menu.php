<bbn-form class="bbn-full-screen bbn-c"
          :source="$data"
          :data="formCopy"
          :action="source.root + 'actions/copy_menu' "
          @success="onSuccess"

>
  <div class="bbn-c bbn-flex-height bbn-padded">
    <div class="bbn-flex-fill elementForm">
      <bbn-input class="bbn-w-100"
                 placeholder="name menu"
                 v-model="newTitleMenu"
                 required="required"
      ></bbn-input>
    </div>
  </div>
</bbn-form>
