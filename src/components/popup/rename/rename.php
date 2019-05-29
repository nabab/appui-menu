<bbn-form class="bbn-c"
          :source= "dataRename"
          :data= "infoData"
          :action="source.root + 'actions/rename_element' "
          :validation="beforeSubmit"
          @success="onSuccess">

  <div class="bbn-c bbn-flex-height bbn-padded">
    <div class="bbn-flex-fill elementForm">
      <bbn-input class="bbn-w-100"
                 v-model="source.titleMenu"
                 readonly
      >
      </bbn-input>
      <div class="bbn-w-100 bbn-c" style="margin-top: 1%">
        <i class="nf nf-fa-arrow_down"></i>
      </div>
      <bbn-input style="margin-top: 1%"
                 class="bbn-w-100"
                 placeholder="<?=_('New name')?>"
                 v-model="dataRename.newTitle"
                 required="required"
      ></bbn-input>
    </div>
  </div>

</bbn-form>
