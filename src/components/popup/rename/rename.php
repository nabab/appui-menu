<bbn-form class="bbn-full-screen bbn-c"
          :source= "$data"
          :data= "infoData"
          :action="source.root + 'actions/rename_element' "
          :validation="beforeSubmit"
          @success="onSuccess">

  <div class="bbn-c bbn-flex-height bbn-padded">
    <div class="bbn-flex-fill elementForm">
      <bbn-input class="bbn-w-100"
                 v-model="source.titleMenu"
                 required="required"
                 readonly
      >
      </bbn-input>
      <div class="bbn-w-100 bbn-c" style="margin-top: 1%">
        <i class="fas fa-arrow-down"></i>
      </div>
      <bbn-input style="margin-top: 1%"
                 class="bbn-w-100"
                 placeholder="new name menu"
                 v-model="newTitle">
      </bbn-input>
    </div>
  </div>

</bbn-form>
