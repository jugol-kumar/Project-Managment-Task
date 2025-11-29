<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
<h1>New Task Assigned</h1>
<p>Hello {{ $task->assignedUser->name }},</p>
<p>You have been assigned a new task in project <strong>{{ $task->project->title }}</strong>.</p>

<ul>
    <li>Title: {{ $task->title }}</li>
    <li>Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</li>
    <li>Status: {{ ucfirst($task->status) }}</li>
</ul>

<p>Thanks, <br> {{ config('app.name') }}</p>
</body>
</html>
