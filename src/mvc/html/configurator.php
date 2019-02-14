<bbn-splitter :orientation="orientation"
              class="appui-menu-constructor-tree">
  <bbn-pane :resizable="true">
    <div class="bbn-flex-height" style="border-right: 1px dotted #CCC">
      <div class="bbn-w-100 k-header" style="height:40px">
        <div class="bbn-full-screen bbn-middle">
          <div class="bbn-flex-width">
            <div style="padding-left: 2px">
              <bbn-dropdown
                style="width:200px"
                ref="listMenus"
                :source="listMenu"
                v-model="currentMenu"
              ></bbn-dropdown>
              <bbn-button @click="prevMenu" title="<?=_('Back menu')?>" v-if="showArrows">
                <i class="fas fa-arrow-left"></i>
              </bbn-button>
              <bbn-button @click="nextMenu" title="<?=_('Next menu')?>" v-if="showArrows">
                <i class="fas fa-arrow-right"></i>
              </bbn-button>
            </div>
            <div class="bbn-flex-fill bbn-r">
              <bbn-button @click="createMenu"
                          title="<?=_('Create menu')?>"
                          icon='zmdi zmdi-menu'
              ></bbn-button>
              <bbn-button @click="createSection"
                          title="<?=_('Create section')?>"
                          icon='far fa-folder'
              ></bbn-button>
              <bbn-button @click="createLink"
                          title="<?=_('Create link')?>"
                          icon="fas fa-link"
              ></bbn-button>
              <bbn-button @click="renameMenu"
                          title="<?=_('Rename menu')?>"
                          icon='far fa-edit'
              ></bbn-button>
              <bbn-button @click="copyMenu"
                          title="<?=_('Copy menu')?>"
                          icon='far fa-clone'
              ></bbn-button>
              <bbn-button @click="copyMenuTo"
                          title="<?=_('Copy menu To')?>"
                          icon='fas fa-copy'
              ></bbn-button>
              <bbn-button @click="deleteMenu"
                          title="<?=_('Delete menu')?>"
                          icon='far fa-trash-alt'
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
        <div class="bbn-full-screen bbn-padded" v-if="currentMenu">
          <bbn-tree :source="root + 'configurator'"
                    :map="mapMenu"
                    uid="id"
                    :root="currentMenu"
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
              @cancel="formCancel">
      <div class="bbn-full-screen bbn-hpadded">
        <div class="bbn-flex-height">
          <h1 class="bbn-c"><?=_('Édition du menu')?></h1>
          <div class="bbn-w-100 bbn-flex-width">
            <div class="bbn-flex-fill">
              <div class="bbn-block bbn-w-20"><?=_('Title')?></div>
              <div class="bbn-block bbn-w-80">
                <bbn-input v-model="selected.text"></bbn-input>
              </div>
              <div class="bbn-nl"> </div>
              <div class="bbn-block bbn-w-20"><?=_('Icon')?></div>
              <div class="bbn-block bbn-w-80">
                <bbn-input v-model="selected.icon"></bbn-input>
                <i style="margin-left: 5%; margin-right: 5%" :class="selected.icon"></i>
                <bbn-button @click="openListIcons"><?=_('Icons')?></bbn-button>
              </div>
            </div>
            <div class="bbn-w-20" v-if="elementMove.data.id && (showOrderDown || showOrderUp)">
              <div class="w3-card bbn-c">
                <div><?=_('Order')?></div>
                <div class="bbn-padded" v-if="showOrderUp">
                  <bbn-button icon="fas fa-arrow-up" @click="moveUp"></bbn-button>
                </div>
                <div class="bbn-padded" v-if="showOrderDown">
                  <bbn-button icon="fas fa-arrow-down" @click="moveDown"></bbn-button>
                </div>
              </div>
            </div>
          </div>
          <div class="bbn-nl"> </div>
          <div class="bbn-w-100 bbn-flex-fill">
            <div class="bbn-full-screen" v-if="selected.id_alias">
              <div class="bbn-block bbn-h-100 bbn-w-20"><?=_('Link')?></div>
              <div class="bbn-block bbn-h-100 bbn-w-80">
                <div class="bbn-full-screen">
                  <div class="bbn-100" style="border: 1px dotted grey">
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
          </div>
          <div class="bbn-nl"> </div>
          <div class="bbn-w-100" v-if="selected.id_alias">
            <div class="bbn-block bbn-w-20"><?=_('Argument')?></div>
            <div class="bbn-block bbn-w-80">
              <bbn-input v-model="selected.argument"></bbn-input>
            </div>
          </div>
          <div class="bbn-nl"> </div>
        </div>
      </div>
    </bbn-form>
    <div v-else
         class="bbn-full-screen bbn-middle bbn-c">
      <h1 v-html="'<?=_("Select or create")?>'+'<br>'+'<?=_("a menu element")?>'+'<br>'+'<?=_("to see the form")?>'+'<br>'+'<?=_("HERE")?>'" style="line-height: 1.4em"></h1>
    </div>
  </bbn-pane>
</bbn-splitter>
