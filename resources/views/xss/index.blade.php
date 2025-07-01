<!DOCTYPE html>
<html>
<head>
    <title>Comments</title>
</head>
<body>
    <h1>Comments</h1>
    <form method="POST" action="/comments">
        @csrf
        <textarea name="content"></textarea>
        <button type="submit">Submit</button>
    </form>

    @foreach ($comments as $comment)
        <div>
            {!! $comment->content !!}
        </div>
    @endforeach
    {{-- 
    1. Chèn mã JavaScript trực tiếp
    <script>alert('Hacked!');</script>
    2. Chèn mã JavaScript qua thuộc tính HTML
    <img src="invalid-image" onerror="alert('Hacked!')">
    3.Chèn mã JavaScript qua URL hoặc liên kết
    <a href="javascript:alert('Hacked!')">Click me</a> --}}
</body>
</html>