<div class="bbn-overlay">
  <div class="bbn-flex-height">
    <div class="bbn-w-100 bbn-header bbn-xspadded bbn-vmiddle appui-menu-configurator-toolbar">
      <div class="bbn-flex-width">
        <div>
          <bbn-button @click="makeDefault"
                      :disabled="!currentID || (currentID === source.defaultMenu)"
                      title="<?=_('Make it default')?>"
                      :notext="true"
                      icon="nf nf-mdi-crown"
                      ></bbn-button>
          <bbn-dropdown v-if="source.menus && source.menus.length"
                        style="width:200px"
                        ref="listMenus"
                        :storage="true"
                        storage-full-name="appui-menu-configurator-picker"
                        :source="source.menus"
                        v-model="currentID"
                        source-text="name"
                        source-value="id"
                        ></bbn-dropdown>
          <bbn-button v-if="showArrows"
                      @click="prevMenu"
                      title="<?=_('Back menu')?>"
                      :notext="true"
                      icon="nf nf-fa-arrow_left"
                      :disabled="!source.menus.length || (currentIdx < 1)"
                      ></bbn-button>
          <bbn-button v-if="showArrows"
                      @click="nextMenu"
                      title="<?=_('Next menu')?>"
                      :notext="true"
                      icon="nf nf-fa-arrow_right"
                      :disabled="!source.menus.length || (currentIdx == (source.menus.length - 1))"
                      ></bbn-button>
        </div>
        <div class="bbn-flex-fill bbn-r">
          <bbn-button @click="createMenu"
                      title="<?=_('Create menu')?>"
                      icon="nf nf-mdi-playlist_plus"
                      :notext="true"
                      ></bbn-button>
          <bbn-button @click="createSection"
                      title="<?=_('Create section')?>"
                      icon="nf nf-mdi-folder_plus"
                      :disabled="disabledAction"
                      :notext="true"
                      ></bbn-button>
          <bbn-button @click="editLink"
                      title="<?=_('Create link')?>"
                      icon="nf nf-fa-link"
                      :disabled="disabledAction"
                      :notext="true"
                      ></bbn-button>
          <bbn-button @click="renameMenu"
                      v-if="selected"
                      title="<?=_('Rename menu')?>"
                      icon="nf nf-fa-edit"
                      :disabled="!currentMenu"
                      :notext="true"
                      ></bbn-button>
          <bbn-button @click="copyMenu"
                      title="<?=_('Copy menu')?>"
                      icon="nf nf-fa-clone"
                      :notext="true"
                      :disabled="!currentMenu"
                      ></bbn-button>
          <bbn-button @click="copyMenuTo"
                      title="<?=_('Copy menu To')?>"
                      icon="nf nf-fa-copy"
                      :notext="true"
                      :disabled="!currentMenu"
                      ></bbn-button>
          <bbn-button @click="fixOrder"
                      title="<?=_('Fix menu order')?>"
                      icon="nf nf-mdi-sort_alphabetical"
                      :disabled="selected && selected.data.numChildren ? false : true"
                      :notext="true"
                      ></bbn-button>
          <bbn-button @click="deleteMenu"
                      title="<?=_('Delete menu')?>"
                      icon="nf nf-fa-trash_o"
                      :disabled="disabledAction"
                      :notext="true"
                      ></bbn-button>
          <bbn-button @click="exportMenu"
                      title="<?=_('Export menu')?>"
                      icon="nf nf-fae-file_export"
                      :disabled="disabledAction"
                      :notext="true"
                      ></bbn-button>
        </div>
      </div>
    </div>
    <div class="bbn-flex-fill">
      <bbn-splitter class="appui-menu-configurator bbn-100"
                    orientation="horizontal"
                    :resizable="true"
                    :resizer-size="10"
      >
        <bbn-pane>
          <div class="bbn-overlay" v-if="currentID">
            <bbn-tree :source="root + 'data/menu'"
                      :map="mapMenu"
                      v-if="!isCurrentIdChanging"
                      :data="{id_menu: currentID}"
                      uid="id"
                      :sortable="true"
                      :menu="contextMenu"
                      @select="selectItem"
                      @unselect="selected = false"
                      ref="menuTree"
                      :draggable="true"
                      @move="moveNode"
                      @beforeOrder="order"
            ></bbn-tree>
          </div>
          <div v-if="!currentMenu.hasItems"
               class="bbn-overlay bbn-middle bbn-c bbn-background"
          >
            <h1 class="bbn-c"><?=_("Empty")?><br><?=_("menu")?></h1>
          </div>
        </bbn-pane>
        <bbn-pane>
          <div class="bbn-flex-height">
            <div class="bbn-header bbn-xspadded bbn-middle appui-menu-configurator-header">
              <div class="bbn-flex-width">
                <div class="bbn-upper bbn-vmiddle">
                  <strong><?=_('MENU EDITOR')?></strong>
                </div>
                <div class="bbn-flex-fill bbn-r">
                  <bbn-button @click="deleteItem(selected)"
                              title="<?=_('Delete menu')?>"
                              icon="nf nf-fa-trash_o"
                              v-if="selected"
                              :notext="true"
                  ></bbn-button>
                </div>
              </div>
            </div>
            <div class="bbn-flex-fill">
              <bbn-form v-if="selected"
                        :source="selected.data"
                        ref="form"
                        :action="root + 'actions/item/' + (selected.data.id ? 'edit' : 'insert')"
                        @success="formSuccess"
                        @cancel="formCancel"
                        :scrollable="true"
              >
                <div class="bbn-padded bbn-grid-fields">
                  <label class="bbn-b"
                         v-if="selected.data.id">
                    <?=_('Order')?>
                  </label>
                  <div v-if="selected.data.id" class="bbn-vmiddle">
                    <i @click="moveUp"
                       :class="['nf', 'nf-fa-caret_up', 'bbn-p', 'bbn-large', {'bbn-disabled-text': selected.source.num === 1}]"
                    ></i>
                    <span class="bbn-hsmargin" v-text="selected.source.num"></span>
                    <i @click="moveDown"
                       :class="['nf', 'nf-fa-caret_down', 'bbn-p', 'bbn-large', {
                         'bbn-disabled-text': selected.source.num === selected.parent.currentData.length
                       }]"
                    ></i>
                  </div>

                  <label class="bbn-b"><?=_('Title')?></label>
                  <bbn-input v-model="selected.data.text"
                             :required="true">
                  </bbn-input>

                  <label class="bbn-b"><?=_('Icon')?></label>
                  <appui-core-input-icon v-model="selected.data.icon"/>

                  <template v-if="selected.data.id_option !== null">
                    <label class="bbn-b"><?=_('Link')?></label>
                    <div class="bbn-iflex-height appui-menu-configurator-permissions">
                      <div class="bbn-rel">
                        <appui-option-input-location v-model="currentLocation"
                                                     @code="c => currentLocationCode = c"/>
                      </div>
                      <div class="bbn-flex-fill">
                        <appui-option-input-access :root="currentLocation"
                                                   :root-code="currentLocationCode"
                                                   v-model="selected.data.id_option"
                                                   :permission="selected.data.link"
                                                   :path="selected.data.path"/>
                      </div>
                    </div>
                    <label><?=_('Argument')?></label>
                    <bbn-input v-model="selected.data.argument"/>
                  </template>
                </div>
              </bbn-form>
              <div v-else
                   class="bbn-overlay bbn-middle bbn-c"
              >
                <h1 v-html="'<?=_("Select or create")?>'+'<br>'+'<?=_("a menu element")?>'+'<br>'+'<?=_("to see the form")?>'+'<br>'+'<?=_("HERE")?>'" style="line-height: 1.4em"></h1>
              </div>
            </div>
          </div>
        </bbn-pane>
      </bbn-splitter>
    </div>
  </div>
</div>
