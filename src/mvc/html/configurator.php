<bbn-splitter :orientation="orientation"
              class="appui-menu-constructor-tree">
  <bbn-pane :resizable="true">
    <div class="bbn-flex-height" style="border-right: 1px dotted #CCC">
      <div class="bbn-w-100 bbn-header">
        <div class="bbn-middle">
          <div class="bbn-flex-width">
            <div style="padding-left: 2px">
              <!-- <bbn-button @click="makeDefault"
                          title="<?=_('Make it default')?>"
                          icon="nf nf-fa-crown"
              ></bbn-button> -->
              <bbn-dropdown style="width:200px"
                            ref="listMenus"
                            :source="list"
                            v-model="treeMenuData.id_menu"
              ></bbn-dropdown>
              <bbn-button v-if="showArrows"
                          @click="prevMenu"
                          title="<?=_('Back menu')?>"
                          :notext="true"
                          icon="nf nf-fa-arrow_left"
              ></bbn-button>
              <bbn-button v-if="showArrows"
                          @click="nextMenu"
                          title="<?=_('Next menu')?>"
                          :notext="true"
                          icon="nf nf-fa-arrow_right"
              ></bbn-button>
            </div>
            <div class="bbn-flex-fill bbn-r">
              <bbn-button @click="createMenu"
                          title="<?=_('Create menu')?>"
                          icon="zmdi zmdi-menu"
                          :notext="true"
              ></bbn-button>
              <bbn-button @click="createSection"
                          title="<?=_('Create section')?>"
                          icon="nf nf-fa-folder"
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
                          title="<?=_('Rename menu')?>"
                          icon="nf nf-fa-edit"
                          :disabled="disabledAction"
                          :notext="true"
              ></bbn-button>
              <bbn-button @click="copyMenu"
                          title="<?=_('Copy menu')?>"
                          icon="nf nf-fa-clone"
                          :notext="true"
              ></bbn-button>
              <bbn-button @click="copyMenuTo"
                          title="<?=_('Copy menu To')?>"
                          icon="nf nf-fa-copy"
                          :notext="true"
              ></bbn-button>
              <bbn-button @click="delMenu"
                          title="<?=_('Delete menu')?>"
                          icon="nf nf-fa-trash_o"
                          :disabled="disabledAction"
                          :notext="true"
              ></bbn-button>
            </div>
          </div>
        </div>
      </div>
      <div class="bbn-flex-fill">
        <div v-if="emptyMenuCurrent && (currentMenu != '')"
             class="bbn-flex-height">
          <div class="bbn-flex-fill bbn-middle">
            <div class="bbn-middle">
              <div class="bbn-c">
                <span class="bbn-c" style="font-size: 6.0em"><?=_("Empty")?></span>
                <br>
                <span class="bbn-c" style="font-size: 6.0em"><?=_("menu")?></span>
              </div>
            </div>
          </div>
        </div>
        <div class="bbn-overlay bbn-padded" v-if="treeMenuData.id_menu.length">
          <bbn-tree :source="root + 'configurator'"
                    :map="mapMenu"
                    :data="treeMenuData"
                    :menu="contextMenu"
                    @select="selectMenu"
                    ref="menus"
                    :draggable="true"
                    @dragEnd="moveNode"
          ></bbn-tree>
        </div>
      </div>
    </div>
  </bbn-pane>
  <bbn-pane :resizable="true">
    <bbn-form v-if="selected"
              :source="selected"
              :data="formData"
              ref="form"
              :action="source.root + 'actions/edit' "
              @success="successEditionMenu"              
              @cancel="formCancel"
              :scrollable="true"
    >
      <div class="bbn-overlay bbn-flex-height bbn-padded">
        <h1 class="bbn-c"><?=_('Édition du menu')?></h1>
        <div class="bbn-w-100 bbn-flex-width"><div class="bbn-w-70">
            <div class="bbn-block bbn-w-20"><?=_('Title')?></div>
            <div class="bbn-block bbn-w-80">
              <bbn-input class="bbn-w-80" v-model="selected.text"></bbn-input>
            </div>
            <div class="bbn-nl"></div>
            <div class="bbn-block bbn-w-20"><?=_('Icon')?></div>
            <div class="bbn-block bbn-w-80">
              <bbn-input class="bbn-w-50" v-model="selected.icon"></bbn-input>
              <i style="margin-left: 5%; margin-right: 5%" :class="selected.icon"></i>
              <bbn-button @click="openListIcons"><?=_('Icons')?></bbn-button>
            </div>
          </div>
          <div class="bbn-flex-fill bbn-c" v-if="elementMove.data.id && (showOrderDown || showOrderUp)">
            <div class="bbn-w-80 bbn-card bbn-c">
              <div><?=_('Order')?></div>
              <div class="bbn-padded" v-if="showOrderUp">
                <bbn-button icon="nf nf-fa-arrow_up" @click="moveUp"></bbn-button>
              </div>
              <div class="bbn-padded" v-if="showOrderDown">
                <bbn-button icon="nf nf-fa-arrow_down" @click="moveDown"></bbn-button>
              </div>
            </div>
          </div>
        </div>
        <div class="bbn-nl"></div>
        <div class="bbn-w-100 bbn-flex-fill" v-if="selected.id_option">
          <div class="bbn-block bbn-h-100 bbn-w-20"><?=_('Link')?></div>
          <div class="bbn-block bbn-h-100 bbn-w-80">
            <div class="bbn-overlay bbn-padded">
              <div class="bbn-h-100" style="border: 1px dotted grey">              
                <bbn-tree source="options/permissions"
                          :map="mapPermissions"
                          uid="id"
                          :root="rootPermission"
                          @select="selectPermission"
                          ref="treePermission"
                          :path="selected.path"
                          :menu="getPermissionsContext"
                ></bbn-tree>
              </div>                
            </div>                
          </div>            
        </div>
        <div class="bbn-nl"> </div>
        <div class="bbn-w-100 bbn-padded" v-if="selected.id_option">
          <div class="bbn-block bbn-w-20"><?=_('Argument')?></div>
          <div class="bbn-block bbn-w-80">
            <bbn-input v-model="selected.argument"></bbn-input>
          </div>
        </div>
        <div class="bbn-nl"></div>
      </div>      
    </bbn-form>
    <div v-else
         class="bbn-overlay bbn-middle bbn-c">
      <h1 v-html="'<?=_("Select or create")?>'+'<br>'+'<?=_("a menu element")?>'+'<br>'+'<?=_("to see the form")?>'+'<br>'+'<?=_("HERE")?>'" style="line-height: 1.4em"></h1>
    </div>
  </bbn-pane>
</bbn-splitter>
