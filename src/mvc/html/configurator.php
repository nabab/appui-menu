<bbn-splitter class="appui-menu-configurator"
              orientation="horizontal"
              :resizable="true"
              :resizer-size="10"
>
  <bbn-pane>
    <div class="bbn-flex-height">
      <div class="bbn-w-100 bbn-header bbn-xspadded bbn-vmiddle appui-menu-configurator-toolbar">
        <div class="bbn-flex-width">
          <div>
            <bbn-button @click="makeDefault"
                        :disabled="!currentID || (currentID === source.defaultMenu)"
                        title="<?=_('Make it default')?>"
                        :notext="true"
                        icon="nf nf-fa-crown"
            ></bbn-button>
            <bbn-dropdown v-if="source.menus && source.menus.length"
                          style="width:200px"
                          ref="listMenus"
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
                        :disabled="!this.source.menus.length || (currentIdx < 1)"
            ></bbn-button>
            <bbn-button v-if="showArrows"
                        @click="nextMenu"
                        title="<?=_('Next menu')?>"
                        :notext="true"
                        icon="nf nf-fa-arrow_right"
                        :disabled="!this.source.menus.length || (currentIdx == (this.source.menus.length - 1))"
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
            <bbn-button @click="createLink"
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
          </div>
        </div>
      </div>
      <div class="bbn-flex-fill">
        <div class="bbn-overlay" v-if="currentID">
          <bbn-tree :source="root + 'data/menu'"
                    :map="mapMenu"
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
      </div>
    </div>
  </bbn-pane>
  <bbn-pane>
    <div class="bbn-flex-height">
      <div class="bbn-header bbn-xspadded bbn-middle appui-menu-configurator-header">
        <div class="bbn-flex-width">
          <div>
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
          <div class="bbn-padded bbn-grid-fields bbn-overlay" :style="formStyle">
            <label v-if="selected.data.id"><?=_('Order')?></label>
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
            <label><?=_('Title')?></label>
            <bbn-input v-model="selected.data.text"></bbn-input>
            <label><?=_('Icon')?></label>
            <div class="bbn-flex-width bbn-vmiddle">
              <bbn-input class="bbn-flex-fill" v-model="selected.data.icon"></bbn-input>
              <i :class="[selected.data.icon, 'bbn-hsmargin', 'bbn-box', 'bbn-xspadded', 'bbn-m']"></i>
              <bbn-button @click="openListIcons" icon="nf nf-oct-search"><?=_('Icons')?></bbn-button>
            </div>
            <template v-if="selected.data.id_option !== null">
              <label><?=_('Link')?></label>
              <div class="bbn-rel appui-menu-configurator-permissions">
                <div class="bbn-overlay bbn-box bbn-spadded">
                  <bbn-tree source="options/permissions"
                            :map="mapPermissions"
                            uid="id"
                            :root="source.rootPermission"
                            @select="selectPermission"
                            ref="permissionsTree"
                            :path="selected.data.path"
                            :menu="getPermissionsContext"
                            @pathChange="permissionsTreeOpenPath"
                  ></bbn-tree>
                </div>
              </div>
              <label><?=_('Argument')?></label>
              <bbn-input v-model="selected.data.argument"></bbn-input>
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