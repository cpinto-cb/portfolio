Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.util.*',
//    'Ext.state.*',
    'Ext.grid.filters.Filters'
]);


Ext.onReady(function(){

//Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

    Ext.define('Servers', {
        extend: 'Ext.data.Model',
        fields: ['id', 'server_id', 'name', 'az', 'type', 'status','public_ip_address','private_ip_address'],
        idProperty: 'id'
    });

    // create the Data Store
    var store = Ext.create('Ext.data.BufferedStore', {
        id: 'store',
        model: 'Servers',
        remoteGroup: true,
        leadingBufferZone: 300,
        pageSize: 100,
        proxy: {
            // load using script tags for cross domain, if the data in on the same domain as
            // this page, an Ajax proxy would be better
            type: 'jsonp',
            url: 'http://localhost/ServerProxy.php',
            reader: {
                rootProperty: 'servers',
                totalProperty: 'totalCount'
            },
            // sends single sort as multi parameter
            simpleSortMode: true,
            // sends single group as multi parameter
            simpleGroupMode: true,

            // This particular service cannot sort on more than one field, so grouping === sorting.
            groupParam: 'sort',
            groupDirectionParam: 'dir'
        },
        sorters: [{
            property: 'id',
            direction: 'ASC'
        }],
        autoLoad: true,
        listeners: {

            // This particular service cannot sort on more than one field, so if grouped, disable sorting
            groupchange: function(store, groupers) {
                var sortable = !store.isGrouped(),
                    headers = grid.headerCt.getVisibleGridColumns(),
                    i, len = headers.length;

                for (i = 0; i < len; i++) {
                    headers[i].sortable = (headers[i].sortable !== undefined) ? headers[i].sortable : sortable;
                }
            },

            // This particular service cannot sort on more than one field, so if grouped, disable sorting
            beforeprefetch: function(store, operation) {
                if (operation.getGrouper()) {
                    operation.setSorters(null);
                }
            }
        }
    });

    var grid = Ext.create('Ext.grid.Panel', {
        width: 700,
        height: 500,
        title: 'ExtJS.com - Browse Forums',
        store: store,
        loadMask: true,

        columns:[

            {
                text: "ID",
                dataIndex: 'id',
                width: 100,
                hidden: true,
                sortable: true,
                groupable: false
            },{
                id: 'az',
                text: "Zone",
                dataIndex: 'az',
                width: 130,
                sortable: true,
                groupable: false
            },{
                id: 'server_id',
                text: "Server Id",
                dataIndex: 'server_id',
                width: 130,
                sortable: true,
                groupable: false
            },{
                text: "Name",
                dataIndex: 'name',
                align: 'center',
                width: 70,
                sortable: true,
                filter: {
                    type: 'string'
                }
            },{
                text: "Status",
                dataIndex: 'status',
                width: 100,
                sortable: true,
                groupable: false
            },{
                text: "Public IP",
                dataIndex: 'public_ip_address',
                width: 100,
                sortable: true,
                groupable: false
            },{
                text: "Private IP",
                dataIndex: 'private_ip_address',
                width: 100,
                sortable: true,
                groupable: false
            },{
            menuDisabled: true,
            sortable: false,
            xtype: 'actioncolumn',
            width: 50,
            items: [
                {
                getClass: function(v, meta, rec) {
                    var state = rec.get('status');
                    if ( state == 'running') return 'stop-col';
                    if ( state == 'stopped') return 'start-col';

                    return 'warn-col';
                },
                getTip: function(v, meta, rec) {

                    var state = rec.get('status');
                    if ( state == 'running') return 'Stop Server';
                    if ( state == 'stopped') return 'Start Server';
                    return 'Server is '+state;

                },
                handler: function(grid, rowIndex, colIndex) {
                    var rec = grid.getStore().getAt(rowIndex),
                        state = rec.get('state'),
                        action = ((state == 'stopped' || state == 'stopping') ? 'Start server ' : 'Stop server ');

                    Ext.Msg.alert(action, action + ' ' + rec.get('server_id'));
                }
            }
            ]}
        ],
        renderTo: Ext.getBody(),
        viewConfig: {
            stripeRows: true
        }
    });
});