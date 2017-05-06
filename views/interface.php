<div class="fm-container">
    <div class="fm-loading-wrap"><!-- loading wrapper / removed when loaded --></div>
    <div class="fm-wrapper">
        <div class="fm-header">
            <div class="current-path">
                <h1 data-bind="text: lg().current_folder + currentPath()"></h1>
            </div>
            <div class="buttons-panel">
                <div class="button-group clipboards-controls" style="display: none">
                    <button id="clipboard-copy" type="button"><span>&nbsp;</span></button>
                    <button id="clipboard-cut" type="button"><span>&nbsp;</span></button>
                    <button id="clipboard-paste" type="button"><span>&nbsp;</span></button>
                    <button id="clipboard-clear" type="button"><span>&nbsp;</span></button>
                    <input id="clipboard-path" name="clipboard-path" type="hidden"/>
                </div>
                <div class="button-group" style="display: none">
                    <button class="separator" type="button">&nbsp;</button>
                </div>
                <div class="button-group navigate-controls">
                    <button class="fm-btn-level-up no-label" type="button" data-bind="click: headerModel.goParent"><span>&nbsp;</span></button>
                    <button class="fm-btn-home no-label" type="button" data-bind="click: headerModel.goHome"><span>&nbsp;</span></button>
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
                            <span data-bind="text: lg().upload"></span>
                        </button>
                    </form>
                </div>
                <div class="button-group create-controls">
                    <button class="fm-btn-create-folder" type="button" data-bind="click: headerModel.createFolder">
                        <span data-bind="text: lg().new_folder"></span>
                    </button>
                </div>
                <!-- /ko -->
                <div class="button-group viewmode-controls">
                    <button class="fm-btn-grid no-label" type="button" data-bind="click: headerModel.displayGrid, attr: {title: lg().grid_view}, css: {active: viewMode() === 'grid'}">
                        <span>&nbsp;</span>
                    </button>
                    <button class="fm-btn-list no-label" type="button" data-bind="click: headerModel.displayList, attr: {title: lg().list_view}, css: {active: viewMode() === 'list'}">
                        <span>&nbsp;</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="fm-splitter">
            <div class="fm-filetree">
                <div data-bind="template: {name: 'node-parent-template', foreach: treeModel.treeData.children, as: 'koNode', afterRender: treeModel.nodeRendered}"></div>
            </div>

            <div class="fm-fileinfo">
                <div class="fm-loading-view" data-bind="visible: loadingView()"></div>


                <ul class="view-items grid" data-bind="visible: !loadingView() && !previewFile() && viewMode() === 'grid', foreach: {data: itemsModel.objects, as: 'koItem'}">
                    <!-- ko if: koItem.rdo.type === "parent" -->
                    <li class="directory-parent" data-bind="click: koItem.open, droppableView: koItem" oncontextmenu="return false;">
                        <div class="item-background"></div>
                        <div class="item-content">
                            <div class="clip">
                                <div class="grid-icon ico_folder_parent" ></div>
                            </div>
                            <p>..</p>
                        </div>
                    </li>
                    <!-- /ko -->

                    <!-- ko if: koItem.rdo.type !== "parent" -->
                    <li data-bind="click: koItem.open, draggableView: koItem, droppableView: koItem, visible: koItem.visible, attr: {class: koItem.cdo.itemClass, title: koItem.title()}">
                        <div class="item-background"></div>
                        <div class="item-content">
                            <div class="clip">
                                <img src="" data-bind="css: koItem.gridIconClass(), attr: {src: koItem.cdo.imageUrl, width: koItem.cdo.previewWidth}" />
                            </div>
                            <p data-bind="text: koItem.rdo.attributes.name"></p>
                        </div>
                    </li>
                    <!-- /ko -->
                </ul>


                <table class="view-items list" data-bind="visible: !loadingView() && !previewFile() && viewMode() === 'list'">
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
                        <tr class="directory-parent" data-bind="click: koItem.open, droppableView: koItem" oncontextmenu="return false;">
                            <td>..</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!-- /ko -->

                        <!-- ko if: koItem.rdo.type !== "parent" -->
                        <tr data-bind="click: koItem.open, droppableView: koItem, attr: {class: koItem.cdo.itemClass, title: koItem.title()}" oncontextmenu="return false;">
                            <td data-bind="draggableView: koItem">
                                <span class="list-icon" data-bind="css: koItem.listIconClass()"></span>
                                <span data-bind="text: koItem.rdo.attributes.name"></span>
                            </td>
                            <td data-bind="text: koItem.rdo.attributes.extension"></td>
                            <td data-bind="text: koItem.cdo.sizeFormatted"></td>
                            <td data-bind="text: koItem.cdo.dimensions"></td>
                            <td data-bind="text: koItem.rdo.attributes.modified"></td>
                        </tr>
                        <!-- /ko -->
                    </tbody>
                </table>


                <!-- ko if: previewFile() -->
                <div class="fm-preview" data-bind="with: previewModel, visible: !loadingView()">
                    <div class="fm-preview-toolbar">
                        <form id="fm-js-preview-toolbar">
                            <button id="parentfolder" type="button" data-bind="event: {click: function(data, event) {$root.headerModel.goParent()}}">
                                <span data-bind="text: $root.lg().parentfolder"></span>
                            </button>
                            <!-- ko if: buttonVisibility('select') -->
                            <button id="select" type="button" data-bind="event: {click: function(data, event) {bindToolbar('select')}}">
                                <span data-bind="text: $root.lg().select"></span>
                            </button>
                            <!-- /ko -->
                            <!-- ko if: buttonVisibility('download') -->
                            <button id="download" type="button" data-bind="event: {click: function(data, event) {bindToolbar('download')}}">
                                <span data-bind="text: $root.lg().download"></span>
                            </button>
                            <!-- /ko -->
                            <!-- ko if: buttonVisibility('rename') -->
                            <button id="rename" type="button" data-bind="event: {click: function(data, event) {bindToolbar('rename')}}">
                                <span data-bind="text: $root.lg().rename"></span>
                            </button>
                            <!-- /ko -->
                            <!-- ko if: buttonVisibility('move') -->
                            <button id="move" type="button" data-bind="event: {click: function(data, event) {bindToolbar('move')}}">
                                <span data-bind="text: $root.lg().move"></span>
                            </button>
                            <!-- /ko -->
                            <!-- ko if: buttonVisibility('delete') -->
                            <button id="delete" type="button" data-bind="event: {click: function(data, event) {bindToolbar('delete')}}">
                                <span data-bind="text: $root.lg().del"></span>
                            </button>
                            <!-- /ko -->
                            <!-- ko if: buttonVisibility('replace') -->
                            <button id="replace" type="button" data-bind="event: {click: function(data, event) {bindToolbar('replace')}}">
                                <span data-bind="text: $root.lg().replace"></span>
                            </button>
                            <div class="hidden-file-input">
                                <input id="replacement" name="replacement" type="file" />
                            </div>
                            <!-- /ko -->
                        </form>
                    </div>

                    <div class="fm-preview-viewer">
                        <!-- ko if: viewer().type === 'image' -->
                        <img src="" data-bind="css: previewIconClass(), attr: {src: viewer().url}" />
                        <!-- /ko -->
                        <!-- ko if: viewer().type === 'editable' -->
                        <img src="" data-bind="css: previewIconClass(), attr: {src: viewer().url}, visible: !editor.enabled()" />
                        <!-- /ko -->
                        <!-- ko if: viewer().type === 'audio' -->
                        <audio src="" controls="controls" data-bind="attr: {src: viewer().url}"></audio>
                        <!-- /ko -->
                        <!-- ko if: viewer().type === 'video' -->
                        <video src="" controls="controls" data-bind="attr: {src: viewer().url, width: viewer().options.width, height: viewer().options.height}"></video>
                        <!-- /ko -->
                        <!-- ko if: viewer().type === 'opendoc' -->
                        <iframe src="" data-bind="attr: {src: viewer().url, width: viewer().options.width, height: viewer().options.height}" allowfullscreen webkitallowfullscreen></iframe>
                        <!-- /ko -->
                        <!-- ko if: viewer().type === 'google' -->
                        <iframe src="" data-bind="attr: {src: viewer().url, width: viewer().options.width, height: viewer().options.height}" allowfullscreen webkitallowfullscreen></iframe>
                        <!-- /ko -->

                        <!-- ko if: editor.enabled() -->
                        <div class="fm-preview-editor">
                            <form id="fm-js-editor-form">
                                <textarea id="fm-js-editor-content" name="content" data-bind="textInput: editor.content"></textarea>
                                <input type="hidden" name="mode" value="savefile" />
                                <input type="hidden" name="path" value="" data-bind="textInput: rdo.id" />
                                <button class="edition" type="button" data-bind="text: $root.lg().quit_editor, click: closeEditor"></button>
                                <button class="edition" type="button" data-bind="text: $root.lg().save, click: saveFile"></button>
                            </form>
                        </div>
                        <!-- /ko -->
                    </div>

                    <div class="fm-preview-title">
                        <div id="main-title">
                            <h1 data-bind="text: rdo.attributes.name, attr: {title: rdo.id}"></h1>
                            <div id="tools">
                                <a href="#" class="fm-btn-edit-file" data-bind="attr: {title: $root.lg().edit}, click: editFile, visible: viewer().type === 'editable' && !editor.enabled()"></a>
                                <a href="#" class="fm-btn-clipboard" id="fm-js-clipboard-copy" data-bind="attr: {title: $root.lg().copy_to_clipboard, 'data-clipboard-text': viewer().url}"></a>
                            </div>
                        </div>
                    </div>

                    <div class="fm-preview-details">
                        <table>
                            <tr data-bind="visible: cdo.sizeFormatted">
                                <td data-bind="text: $root.lg().size"></td>
                                <td data-bind="text: cdo.sizeFormatted"></td>
                            </tr>
                            <tr data-bind="visible: cdo.dimensions">
                                <td data-bind="text: $root.lg().dimensions"></td>
                                <td data-bind="text: cdo.dimensions"></td>
                            </tr>
                            <tr data-bind="visible: rdo.attributes.created">
                                <td data-bind="text: $root.lg().created"></td>
                                <td data-bind="text: rdo.attributes.created"></td>
                            </tr>
                            <tr data-bind="visible: rdo.attributes.modified">
                                <td data-bind="text: $root.lg().modified"></td>
                                <td data-bind="text: rdo.attributes.modified"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /ko -->
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

        <script type="text/html" id="node-parent-template">
            <li data-bind="template: {name: 'node-template', data: koNode}"></li>
        </script>

        <script type="text/html" id="node-template">
            <span class="button switch" data-bind="css: switcherClass(), click: switchNode"></span>
            <a data-bind="attr: {class: cdo.itemClass}, event: {click: nodeClick, dblclick: nodeDblClick}, draggableTree: $data, droppableTree: $data">
                <span class="button" data-bind="css: iconClass()"></span>
                <span class="node_name" data-bind="text: nodeTitle(), attr: {title: title()}"></span>
            </a>
            <ul data-bind="template: {name: 'node-parent-template', if: children().length > 0, foreach: children, as: 'koNode', afterRender: $root.treeModel.nodeRendered}, css: clusterClass(), toggleNodeVisibility: $data"></ul>
        </script>
    </div>
</div>