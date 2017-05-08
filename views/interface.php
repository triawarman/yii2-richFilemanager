<div class="fm-container">
    <div class="fm-loading-wrap"><!-- loading wrapper / removed when loaded --></div>
    <div class="fm-wrapper">
        <div class="fm-header">
            <div class="breadcrumbs">
                <div class="nav-title" data-bind="text: lg().current_folder"></div>
                <div data-bind="foreach: {data: breadcrumbsModel.items, as: 'bcItem'}">
                    <div data-bind="text: bcItem.label, click: bcItem.goto, css: bcItem.itemClass()"></div>
                    <!-- ko if: !bcItem.active -->
                    <div class="separator">&gt;</div>
                    <!-- /ko -->
                </div>
            </div>
            <div class="buttons-panel">
                <!-- ko if: clipboardModel.enabled() -->
                <div class="button-group clipboards-controls">
                    <button class="btn-clipboard-copy no-label" type="button" data-bind="click: clipboardModel.copy, visible: clipboardModel.hasCapability('copy'), attr: {title: localizeGUI() ? lg().clipboard_copy : null}"><span>&nbsp;</span></button>
                    <button class="btn-clipboard-cut no-label" type="button" data-bind="click: clipboardModel.cut, visible: clipboardModel.hasCapability('cut'), attr: {title: localizeGUI() ? lg().clipboard_cut : null}"><span>&nbsp;</span></button>
                    <button class="btn-clipboard-paste no-label" type="button" data-bind="click: clipboardModel.paste, visible: clipboardModel.hasCapability('paste'), attr: {title: localizeGUI() ? lg().clipboard_paste_full : null}"><span>&nbsp;</span></button>
                    <button class="btn-clipboard-clear no-label" type="button" data-bind="click: clipboardModel.clear, visible: clipboardModel.hasCapability('clear'), attr: {title: localizeGUI() ? lg().clipboard_clear_full : null}"><span>&nbsp;</span></button>
                </div>
                <div class="button-group">
                    <button class="separator" type="button">&nbsp;</button>
                </div>
                <!-- /ko -->
                <div class="button-group navigate-controls">
                    <button class="btn-level-up no-label" type="button" data-bind="click: headerModel.goParent, attr: {title: localizeGUI() ? lg().go_level_up : null}">
                        <span>&nbsp;</span>
                    </button>
                    <button class="btn-home-folder no-label" type="button" data-bind="click: headerModel.goHome, attr: {title: localizeGUI() ? lg().go_home : null}">
                        <span>&nbsp;</span>
                    </button>
                </div>
                <!-- ko if: !browseOnly() -->
                <div class="button-group upload-controls">
                    <form class="fm-uploader" method="post">
                        <input id="mode" type="hidden" value="add"/>
                        <div id="file-input-container">
                            <div id="alt-fileinput">
                                <input id="filepath" name="filepath" type="text"/>
                                <button id="browse" type="button" data-bind="attr: {title: lg().browse}">+</button>
                            </div>
                            <input id="newfile" name="newfile" type="file" />
                        </div>
                        <button class="fm-upload" type="button">
                            <span data-bind="text: lg().action_upload"></span>
                        </button>
                    </form>
                </div>
                <div class="button-group create-controls">
                    <button class="btn-create-folder" type="button" data-bind="click: headerModel.createFolder">
                        <span data-bind="text: lg().new_folder"></span>
                    </button>
                </div>
                <!-- /ko -->
                <div class="button-group viewmode-controls">
                    <button class="btn-grid-mode no-label" type="button" data-bind="click: headerModel.displayGrid, attr: {title: localizeGUI() ? lg().grid_view : null}, css: {active: viewMode() === 'grid'}">
                        <span>&nbsp;</span>
                    </button>
                    <button class="btn-list-mode no-label" type="button" data-bind="click: headerModel.displayList, attr: {title: localizeGUI() ? lg().list_view : null}, css: {active: viewMode() === 'list'}">
                        <span>&nbsp;</span>
                    </button>
                </div>
                <!-- ko if: headerModel.closeButton() -->
                <div class="button-group">
                    <button class="btn-close-window no-label" type="button" data-bind="click: headerModel.closeButtonOnClick, attr: {title: localizeGUI() ? lg().close : null}">
                        <span>&nbsp;</span>
                    </button>
                </div>
                <!-- /ko -->
            </div>
        </div>

        <div class="fm-splitter">
            <div class="fm-filetree" data-bind="visible: config().filetree.enabled">
                <div data-bind="template: {name: 'node-parent-template', foreach: treeModel.treeData.children, as: 'koNode', afterRender: treeModel.nodeRendered}"></div>
            </div>

            <div class="fm-fileinfo">
                <div class="fm-loading-view" data-bind="visible: loadingView()"></div>

                <div class="view-items-wrapper" data-bind="visible: !loadingView() && !previewFile()">
                    <!-- ko if: config().manager.renderer.position === 'top' && itemsModel.descriptivePanel.renderer() -->
                    <div class="fm-renderer-wrapper" data-bind="visible: itemsModel.descriptivePanel.content()">
                        <!-- ko template: {name: 'renderer-template', data: itemsModel.descriptivePanel} --><!-- /ko -->
                    </div>
                    <!-- /ko -->

                    <div class="view-items">
                        <ul class="grid" data-bind="visible: viewMode() === 'grid', foreach: {data: itemsModel.objects, as: 'koItem'}">
                            <!-- ko if: koItem.rdo.type === "parent" -->
                            <li class="directory-parent" data-bind="event: {click: koItem.open, dblclick: koItem.open}, droppableView: koItem, css: koItem.itemClass()" oncontextmenu="return false;">
                                <div class="clip">
                                    <img src="" class="grid-icon ico_folder_parent" data-bind="attr: {src: null, width: $root.config().viewer.image.thumbMaxWidth}" />
                                </div>
                                <p>..</p>
                            </li>
                            <!-- /ko -->

                            <!-- ko if: koItem.rdo.type !== "parent" -->
                            <li data-bind="event: {click: koItem.open, dblclick: koItem.open, mousedown: koItem.mouseDown}, droppableView: koItem, visible: koItem.visible, attr: {title: koItem.title()}, css: koItem.itemClass()">
                                <div class="item-background"></div>
                                <div class="item-content" data-bind="draggableView: koItem">
                                    <div class="clip">
                                        <img src="" data-bind="css: koItem.gridIconClass(), attr: {src: koItem.cdo.imageUrl, width: koItem.cdo.previewWidth}" />
                                    </div>
                                    <p data-bind="text: koItem.rdo.attributes.name"></p>
                                </div>
                            </li>
                            <!-- /ko -->
                        </ul>


                        <table class="list" data-bind="visible: viewMode() === 'list'">
                            <thead>
                                <tr class="rowHeader" data-bind="with: tableViewModel">
                                    <th data-bind="click: thName.sort, css: thName.sortClass()"><span data-bind="text: $root.lg().name"></span></th>
                                    <th data-bind="click: thType.sort, css: thType.sortClass()"><span data-bind="text: $root.lg().type"></span></th>
                                    <th data-bind="click: thSize.sort, css: thSize.sortClass()"><span data-bind="text: $root.lg().size"></span></th>
                                    <th data-bind="click: thDimensions.sort, css: thDimensions.sortClass()"><span data-bind="text: $root.lg().dimensions"></span></th>
                                    <th data-bind="click: thModified.sort, css: thModified.sortClass()"><span data-bind="text: $root.lg().modified"></span></th>
                                </tr>
                            </thead>
                            <tbody data-bind="foreach: {data: itemsModel.objects, as: 'koItem'}">
                                <!-- ko if: koItem.rdo.type === "parent" -->
                                <tr class="directory-parent" data-bind="event: {click: koItem.open, dblclick: koItem.open}, droppableView: koItem, css: koItem.itemClass()" oncontextmenu="return false;">
                                    <td>
                                        <div class="list-item">..</div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <!-- /ko -->

                                <!-- ko if: koItem.rdo.type !== "parent" -->
                                <tr data-bind="event: {click: koItem.open, dblclick: koItem.open, mousedown: koItem.mouseDown}, droppableView: koItem, attr: {title: koItem.title()}, css: koItem.itemClass()" oncontextmenu="return false;">
                                    <td>
                                        <div class="list-item" data-bind="draggableView: koItem">
                                            <span class="list-icon" data-bind="css: koItem.listIconClass()"></span>
                                            <span data-bind="text: koItem.rdo.attributes.name"></span>
                                        </div>
                                    </td>
                                    <td data-bind="text: koItem.rdo.attributes.extension"></td>
                                    <td data-bind="text: koItem.cdo.sizeFormatted"></td>
                                    <td data-bind="text: koItem.cdo.dimensions"></td>
                                    <td data-bind="text: koItem.rdo.attributes.modified"></td>
                                </tr>
                                <!-- /ko -->
                            </tbody>
                        </table>
                    </div>

                    <!-- ko if: config().manager.renderer.position === 'bottom' && itemsModel.descriptivePanel.renderer() -->
                    <div class="fm-renderer-wrapper" data-bind="visible: itemsModel.descriptivePanel.content()">
                        <!-- ko template: {name: 'renderer-template', data: itemsModel.descriptivePanel} --><!-- /ko -->
                    </div>
                    <!-- /ko -->
                </div>


                <div class="fm-preview-wrapper" data-bind="visible: !loadingView() && previewFile()">
                    <!-- ko template: {if: previewFile(), afterRender: previewModel.afterRender} -->
                    <div class="fm-preview" data-bind="with: previewModel">
                        <div class="fm-preview-toolbar">
                            <form id="fm-js-preview-toolbar">
                                <button class="btn-file-preview-close" type="button" data-bind="event: {click: function(data, event) {$root.headerModel.goParent()}}">
                                    <span data-bind="text: $root.lg().parentfolder"></span>
                                </button>
                                <!-- ko if: buttonVisibility('select') -->
                                <button class="btn-file-select" type="button" data-bind="event: {click: function(data, event) {bindToolbar('select')}}">
                                    <span data-bind="text: $root.lg().action_select"></span>
                                </button>
                                <!-- /ko -->
                                <!-- ko if: buttonVisibility('download') -->
                                <button class="btn-file-download" type="button" data-bind="event: {click: function(data, event) {bindToolbar('download')}}">
                                    <span data-bind="text: $root.lg().action_download"></span>
                                </button>
                                <!-- /ko -->
                                <!-- ko if: buttonVisibility('rename') -->
                                <button class="btn-file-rename" type="button" data-bind="event: {click: function(data, event) {bindToolbar('rename')}}">
                                    <span data-bind="text: $root.lg().action_rename"></span>
                                </button>
                                <!-- /ko -->
                                <!-- ko if: buttonVisibility('move') -->
                                <button class="btn-file-move" type="button" data-bind="event: {click: function(data, event) {bindToolbar('move')}}">
                                    <span data-bind="text: $root.lg().action_move"></span>
                                </button>
                                <!-- /ko -->
                                <!-- ko if: buttonVisibility('delete') -->
                                <button class="btn-file-delete" type="button" data-bind="event: {click: function(data, event) {bindToolbar('delete')}}">
                                    <span data-bind="text: $root.lg().action_delete"></span>
                                </button>
                                <!-- /ko -->
                                <!-- ko if: buttonVisibility('replace') -->
                                <button class="btn-file-replace" type="button" data-bind="event: {click: function(data, event) {bindToolbar('replace')}}">
                                    <span data-bind="text: $root.lg().action_replace"></span>
                                </button>
                                <!-- /ko -->
                                <!-- ko if: viewer.isEditable() && !editor.enabled() -->
                                <button class="btn-file-edit" type="button" data-bind="click: editFile">
                                    <span data-bind="text: $root.lg().editor_edit"></span>
                                </button>
                                <!-- /ko -->
                                <!-- ko if: viewer.isEditable() && editor.enabled() -->
                                <button class="btn-file-save" type="button" data-bind="click: saveFile">
                                    <span data-bind="text: $root.lg().editor_save"></span>
                                </button>
                                <button class="btn-file-editor-close" type="button" data-bind="click: closeEditor">
                                    <span data-bind="text: $root.lg().editor_quit"></span>
                                </button>
                                <!-- /ko -->
                            </form>
                        </div>

                        <div class="fm-preview-viewer" data-bind="css: {'side-by-side-panels': editor.enabled() && editor.isInteractive()}">
                            <!-- ko template: {if: viewer.isEditable(), afterRender: initiateEditor} -->
                            <div class="fm-preview-edit-panel" data-bind="visible: editor.enabled()">
                                <form id="fm-js-editor-form">
                                    <textarea class="fm-cm-editor-content" name="content" data-bind="textInput: editor.content()"></textarea>
                                    <input type="hidden" name="mode" value="savefile" />
                                    <input type="hidden" name="path" value="" data-bind="textInput: rdo().id" />
                                </form>
                            </div>
                            <!-- /ko -->

                            <div class="fm-preview-view-panel">
                                <!-- ko if: viewer.type() === 'default' -->
                                <img src="" data-bind="css: previewIconClass(), attr: {src: null}" />
                                <!-- /ko -->
                                <!-- ko if: viewer.type() === 'image' -->
                                <img src="" data-bind="css: previewIconClass(), attr: {src: viewer.url()}" />
                                <!-- /ko -->
                                <!-- ko if: viewer.type() === 'audio' -->
                                <audio src="" controls="controls" data-bind="attr: {src: viewer.url()}"></audio>
                                <!-- /ko -->
                                <!-- ko if: viewer.type() === 'video' -->
                                <video src="" controls="controls" data-bind="attr: {src: viewer.url(), width: viewer.options().width, height: viewer.options().height}"></video>
                                <!-- /ko -->
                                <!-- ko if: viewer.type() === 'opendoc' -->
                                <iframe src="" data-bind="attr: {src: viewer.url(), width: viewer.options().width, height: viewer.options().height}" allowfullscreen webkitallowfullscreen></iframe>
                                <!-- /ko -->
                                <!-- ko if: viewer.type() === 'google' -->
                                <iframe src="" data-bind="attr: {src: viewer.url(), width: viewer.options().width, height: viewer.options().height}" allowfullscreen webkitallowfullscreen></iframe>
                                <!-- /ko -->
                                <!-- ko if: viewer.type() === 'renderer' && renderer.renderer() -->
                                <div data-bind="visible: !editor.enabled() || editor.isInteractive()">
                                    <!-- ko template: {name: 'renderer-template', data: renderer} --><!-- /ko -->
                                </div>
                                <!-- /ko -->
                            </div>
                        </div>

                        <div class="fm-preview-title">
                            <h1 data-bind="text: rdo().attributes.name, attr: {title: rdo().id}"></h1>
                            <div class="fm-preview-title-controls">
                                <a href="#" class="btn-copy-url" data-bind="attr: {title: $root.lg().copy_to_clipboard, 'data-clipboard-text': viewer.pureUrl()}"></a>
                                <!-- ko if: viewer.isEditable() && !editor.enabled() -->
                                <a href="#" class="btn-editor-open" data-bind="attr: {title: $root.lg().editor_edit}, click: editFile"></a>
                                <!-- /ko -->
                                <!-- ko if: viewer.isEditable() && editor.enabled() -->
                                <a href="#" class="btn-editor-save" data-bind="attr: {title: $root.lg().editor_save}, click: saveFile"></a>
                                <a href="#" class="btn-editor-quit" data-bind="attr: {title: $root.lg().editor_quit}, click: closeEditor"></a>
                                <!-- /ko -->
                            </div>
                        </div>

                        <div class="fm-preview-details">
                            <table>
                                <tr data-bind="visible: cdo().sizeFormatted">
                                    <td data-bind="text: $root.lg().size"></td>
                                    <td data-bind="text: cdo().sizeFormatted"></td>
                                </tr>
                                <tr data-bind="visible: cdo().dimensions">
                                    <td data-bind="text: $root.lg().dimensions"></td>
                                    <td data-bind="text: cdo().dimensions"></td>
                                </tr>
                                <tr data-bind="visible: rdo().attributes.created">
                                    <td data-bind="text: $root.lg().created"></td>
                                    <td data-bind="text: rdo().attributes.created"></td>
                                </tr>
                                <tr data-bind="visible: rdo().attributes.modified">
                                    <td data-bind="text: $root.lg().modified"></td>
                                    <td data-bind="text: rdo().attributes.modified"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /ko -->
                </div>

            </div>
        </div>

        <div class="fm-footer">
            <div class="left">
                <div class="search-box" data-bind="visible: config().options.searchBox">
                    <input type="text" data-bind="value: searchModel.value(), event: {keyup: searchModel.findAll}" />
                    <div class="search-box-reset" data-bind="event: {click: searchModel.reset}"></div>
                </div>
            </div>

            <div class="right">
                <div id="folder-info">
                    <span data-bind="text: itemsModel.objectsNumber() + ' ' + lg().items"></span> -
                    <span data-bind="text: lg().size + ': ' + itemsModel.objectsSize()"></span>
                </div>
                <div id="summary" data-bind="click: summaryModel.doSummarize"></div>
                <a href="" target="_blank" id="link-to-project" data-bind="attr: {href: config().url, title: lg().support_fm + ' [' + lg().version + ' : ' + config().version + ']'}"></a>
            </div>
            <div style="clear: both"></div>
        </div>

        <!-- ko if: summaryModel.enabled() -->
        <div id="summary-popup" data-bind="visible: false">
            <div class="title" data-bind="text: lg().summary_title"></div>
            <div class="line" data-bind="text: lg().summary_files + ': ' + summaryModel.files()"></div>
            <div class="line" data-bind="text: lg().summary_folders + ': ' + summaryModel.folders(), visible: summaryModel.folders()"></div>
            <div class="line" data-bind="text: lg().summary_size + ': ' + summaryModel.size()"></div>
        </div>
        <!-- /ko -->


        <!-- TEMPLATES Start -->
        <script type="text/html" id="renderer-template">
            <!-- ko template: {afterRender: setContainer} -->
            <div class="fm-renderer-container">
                <!-- ko if: renderer().name === 'markdown' -->
                <div class="fm-markdown-renderer" data-bind="html: content()"></div>
                <!-- /ko -->
                <!-- ko if: renderer().name === 'codeMirror' -->
                <textarea class="fm-cm-renderer-content" data-bind="textInput: content()"></textarea>
                <!-- /ko -->
            </div>
            <!-- /ko -->
            </script>

            <script type="text/html" id="node-parent-template">
                <li data-bind="template: {name: 'node-template', data: koNode}, css: koNode.itemClass()"></li>
                </script>

                <script type="text/html" id="node-template">
                    <div class="row" data-bind="droppableTree: $data"></div>
                    <span class="button switch" data-bind="css: switcherClass(), click: switchNode"></span>
                    <a data-bind="attr: {class: cdo.cssItemClass}, event: {click: nodeClick, dblclick: nodeDblClick, mousedown: mouseDown}, draggableTree: $data">
                        <span class="button" data-bind="css: iconClass()"></span>
                        <span class="node_name" data-bind="text: nodeTitle(), attr: {title: title()}"></span>
                    </a>
                    <ul data-bind="template: {name: 'node-parent-template', if: children().length > 0, foreach: children, as: 'koNode', afterRender: $root.treeModel.nodeRendered}, css: clusterClass(), toggleNodeVisibility: $data"></ul>
                    </script>
                    <!-- TEMPLATES End-->


                    <div id="drag-helper-template" style="display: none">
                        <div class="drag-helper">
                            <div class="item-background"></div>
                            <div class="item-content">
                                <div class="clip grid-icon"></div>
                            </div>
                            <div class="dragging-stop">
                                <div class="cancel-image"></div>
                            </div>
                            <div class="dragging-counter" data-bind="visible: itemsModel.selectedNumber() > 1">
                                <span data-bind="text: itemsModel.selectedNumber()"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>