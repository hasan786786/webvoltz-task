<div class="wrap">
    <h1>Realtime Sync Logs</h1>

    <form id="wprts-logs-filter" style="margin-bottom:20px;">
        <select name="role" id="wprts-role">
            <option value="">All Roles</option>
            <option value="host">Host</option>
            <option value="target">Target</option>
        </select>

        <select name="status" id="wprts-status">
            <option value="">All Status</option>
            <option value="success">Success</option>
            <option value="error">Error</option>
        </select>

        <button type="submit" class="button">Filter</button>
    </form>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Role</th>
                <th>Action</th>
                <th>Host Post ID</th>
                <th>Target Post ID</th>
                <th>Target URL</th>
                <th>Status</th>
                <th>Message</th>
                <th>Duration (s)</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody id="wprts-logs-body">
            <tr><td colspan="10">Loading logs...</td></tr>
        </tbody>
    </table>
</div>
