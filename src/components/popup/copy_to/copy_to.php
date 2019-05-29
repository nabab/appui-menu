<bbn-form class="bbn-c"
          :source="infoCopy"
          :data="menuInfo"
          :action="source.root + 'actions/copy_menu_to'"
          @success="onSuccess"
          :prefilled="true"
>
  <div class="bbn-grid-fields bbn-l bbn-padded">
    <label class="bbn-b" ><?=_("Menu")?>:</label>
    <bbn-dropdown style="width:200px"
                  :source="source.listMenu"
                  v-model="info.id_menu_to"
    ></bbn-dropdown>
    <label class="bbn-b" ><?=_("Title")?>:</label>
    <bbn-input v-model="info.text"></bbn-input>

    <label><?=_('Icon')?></label>
    <div>
      <bbn-input v-model="info.icon"></bbn-input>
      <i style="margin-left: 5%; margin-right: 5%" :class="info.icon"></i>
      <bbn-button @click="listIcon"><?=_('Icons')?></bbn-button>
    </div>
  </div>
</bbn-form>
