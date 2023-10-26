@extends('developer.index')

@section('developer-content')
<div class="mt-3 px-3">
    <p>Ready to deploy your application or need to save this application state for future development? Follow the steps
        below:&nbsp;</p>

    <p>1. Download the packaged application file&nbsp;</p>

    <p>Click the &quot;Download Files&quot; button below for the platform to automatically package the application
        features built into a simple .iwt file. This file can then be shared with others for further development by
        uploading in &ldquo;Application Development&rdquo; or deployed as shown in step 2.&nbsp;</p>
    <p><a class="btn btn-primary" href="{{route("developer.download")}}">Download Files</a></p>

    <p>2. Deploy the application in one of two ways:&nbsp;</p>

    <p>&nbsp; &nbsp; 2.1 On the platform&nbsp;</p>

    <p>&nbsp; &nbsp; Go to &quot;Application Management&quot; to create a new application and then upload the .iwt file
        in the application upload field.&nbsp;</p>

    <p><img alt="" src="/media/images/examples/deploy1.png" width="800px">
    </p>

    <p>&nbsp; &nbsp; 2.2 On .iwt supported environment&nbsp;</p>

    <p>&nbsp; &nbsp; For .iwt supported environment on premises, go to the application deployment page and upload this
        application file.&nbsp;&nbsp;</p>
    
    <p>3. Deploy to Sandbox&nbsp;</p>

    <p><a class="btn btn-primary" href="#"> Deploy Now</a></p>

    <p>&nbsp; &nbsp; Deploy the application into a test environment(This server) for local testing.&nbsp;&nbsp;</p>
</div>
@endsection