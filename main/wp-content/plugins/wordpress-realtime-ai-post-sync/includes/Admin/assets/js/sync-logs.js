jQuery(document).ready(function($){

    function fetchLogs(){
        let role   = $('#wprts-role').val();
        let status = $('#wprts-status').val();

        $.ajax({
            url: wprts_logs_ajax.ajax_url,
            method: 'POST',
            data: {
                action: 'wprts_get_logs',
                nonce: wprts_logs_ajax.nonce,
                role: role,
                status: status
            },
            beforeSend: function(){
                $('#wprts-logs-body').html('<tr><td colspan="10">Loading...</td></tr>');
            },
            success: function(data){
                $('#wprts-logs-body').html(data);
            },
            error: function(){
                $('#wprts-logs-body').html('<tr><td colspan="10">Error loading logs.</td></tr>');
            }
        });
    }

    fetchLogs();

    $('#wprts-logs-filter').on('submit', function(e){
        e.preventDefault();
        fetchLogs();
    });
});
