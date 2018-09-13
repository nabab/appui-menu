<bbn-form class="bbn-full-screen bbn-c"
          :source="$data"
          :action="source.root + 'actions/create_menu' "
          @success="onSuccess"
          @failure="onFailure"
>
  <div class="bbn-c bbn-flex-height bbn-padded">
    <div class="bbn-flex-fill elementForm">
      <bbn-input class="bbn-w-100"
                 placeholder="Title new menu"
                 v-model="titleMenu"
                 required="required"
      ></bbn-input>
    </div>
  </div>
</bbn-form>
