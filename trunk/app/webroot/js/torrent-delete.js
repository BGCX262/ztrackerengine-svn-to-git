Ext.onReady(function() {
	function removeTor()
	{
		Ext.Ajax.request({
			url:'../delete',
			params:{id:torid},
			success: function() {  location.reload();  }
		});
	}

	Ext.addBehaviors({"#deltorrent a@click":removeTor});
});