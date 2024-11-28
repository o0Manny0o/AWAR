<x-mail.layout
    :lang="$lang"
    :title="$title">
    @section('content')
        <table role="presentation">
            <tbody>
            <tr align="left">
                <td>
                    <div style="font-size: 14px; line-height: 140%; text-align: left; word-wrap: break-word;">

                        <h1 style="line-height: 140%;">{{ __('organisations.invitation.mail.header') }}</h1>
                    </div>
                </td>
            </tr>
            <tr align="left">
                <td style="padding: 10px 0">
                    <div style="font-size: 14px; line-height: 140%; text-align: left; word-wrap: break-word;">
                        <p style="line-height: 140%;">
                            {!! __('organisations.invitation.mail.body', ['name' => $organisation->name, 'inviter' => $inviter->name]) !!}
                        </p>
                    </div>
                </td>
            </tr>
            <tr align="left">
                <td style="padding: 10px 0">
                    <div style="font-size: 14px; line-height: 140%; text-align: left; word-wrap: break-word;">
                        <p style="line-height: 140%;">
                            {!! __('organisations.invitation.mail.get_started') !!}
                        </p>
                    </div>
                </td>
            </tr>

            <tr align="left">
                <td style="padding: 25px 0">
                    <a style="padding: 10px 14px; background: #2563eb; border-radius: 6px; color: white; font-weight: 600; font-size: 14px; line-height: 120%; text-decoration: none"
                       href="{{ $url }}">Click to join</a>
                </td>
            </tr>

            <tr align="left">
                <td style="padding: 25px 0">

                    <div style="font-size: 14px; line-height: 140%; text-align: left; word-wrap: break-word;">
                        <p style="line-height: 140%;">
                            {!! __('organisations.invitation.mail.regards') !!}
                        </p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>






        </div>

    @stop
</x-mail.layout>
