@extends('layouts.lesson')

@section('content')
    @if ($lesson->type == 'text')
    @php
        $curl = curl_init();

        // echo $_ENV['GITHUB_LESSON_BASE'] . $course->slug . '/' . $lesson->slug . '.md';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $_ENV['GITHUB_LESSON_BASE'] . $course->slug . '/' . $lesson->slug . '.md',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    @endphp
        {!!
            app(Spatie\LaravelMarkdown\MarkdownRenderer::class)->toHtml($response);
        !!}
        <script>
            
        </script>
    @endif
@endsection