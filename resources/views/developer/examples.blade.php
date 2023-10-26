@extends('developer.index')

@section('developer-content')
    <div class="mt-3 px-3">
        <h3><strong> ADC V1.0</strong></h3>

        <ol>
            <li>
                System configuration<br/>
                This software runs on an industrial control computer.<br/>
                （1）Industrial control computer based on ACPI x64;<br/>
                （2）Processor: Intel(R) Xeon(R) Silver 4114 CPU @ 2.20GHz 10 Cores 20;<br/>
                （3）Memory: 128 G;<br/>
                （4）Hard disk: 10T<br/>
            </li>
            <li>
                <p>Software architecture<br/></p>
                <img alt="" src="/media/images/examples/adc295.png" width="400px">
            </li>
            <li>
                <p>Monitor<br/>
                    The diagram mainly consists of two parts. The left half is the queue for real-time data, where the
                    lot
                    data that needs to be monitored is added to the queue. The right half mainly includes the display
                    section of the data, including graphical data display and tabular data display.</p>
                <img alt="" src="/media/images/examples/adc1171.png" width="400px">
            </li>
        </ol>
    </div>
    <div>
        <h3><strong> RFID V1.0</strong></h3>

        <ol>
            <li>
                System configuration<br/>
                This software runs on an industrial control computer.<br/>
                （1）Installed the Windows 10 Home operating system;<br/>
                （2）The system requires installation of .NET Framework 4.0;<br/>
            </li>
            <li>
                <p>Software architecture<br/></p>
                <img alt="" src="/media/images/examples/rfid323.png" width="400px">
            </li>
            <li>
                <p>Monitor<br/>
                    When the status of a label at a certain location changes, the system will automatically send JSON
                    messages to the configured HTTP interface. As shown in Figure 3-5, the client displays the received
                    information.</p>
                <img alt="" src="/media/images/examples/rfid708.png" width="400px">
            </li>
        </ol>
    </div>

@endsection