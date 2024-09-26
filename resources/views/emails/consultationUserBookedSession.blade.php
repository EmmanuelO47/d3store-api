<div style="line-height:inherit;margin:0;background-color:#F2F2F2">
    <table cellpadding="0" cellspacing="0" role="presentation" width="100%" bgcolor="#F2F2F2" valign="top" style="line-height:inherit;table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;background-color:#F2F2F2;width:100%;text-align: center;">
        <tbody style="line-height:inherit">
            <tr valign="top">
                <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;text-align: center;padding:47px 0 52px;">
                    <table cellpadding="0" cellspacing="0" role="presentation" width="100%" bgcolor="#FFFFFF" valign="top" style="line-height:inherit;table-layout:fixed;vertical-align:top;min-width:320px;max-width: 612px;border-spacing:0;border-collapse:collapse;background-color:#ffffff;width:100%;margin: 0 auto;">
                        <tbody style="line-height:inherit">
                            <tr valign="top" style="line-height:inherit;border-collapse:collapse;vertical-align:top">
                                <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;text-align: center;padding: 58px 60px 51px;">
                                    <img src="https://res.cloudinary.com/dq10kifw9/image/upload/v1712140584/cmsLogo_jjukmi.png" alt="logo" width="115" height="36" style="object-fit: contain;" />
                                </td>
                            </tr>
                            <tr valign="top" style="line-height:inherit;border-collapse:collapse;vertical-align:top">
                                <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;font-family: 'Roboto',Arial,sans-serif;font-style: normal;font-weight: 400;font-size: 16px;line-height: 26px;color: #495057;padding: 0px 60px 20px;text-align: left;">
                                    <p style="margin:0;">Hi {{ $user->first_name }}, </p>
                                    <p style="margin:0;">Congratulations,  {{ $bookedSessionUser->first_name }} booked a one-to-one session with you.</p>
                                    <br/>
                                    <p style="margin:0;">Find details below:</p>
                                    <br/>
                                    <p style="margin:0;">Name: <b>{{ $bookedSessionUser->first_name }} {{ $bookedSessionUser->last_name }}</b></p>
                                    <p style="margin:0;">Purpose of Meeting: <b>{{ $sessionData['purpose_of_meeting'] }}</b></p>
                                    <p style="margin:0;">Additional Information: <b>{{ $sessionData['additional_information'] }}</b></p>
                                    <p style="margin:0;">Date and Time: <b>{{ date('dS F, Y . ha', strtotime($sessionData['booking_datetime'])) }}</b></p>
                                </td>
                            </tr>
                            <tr valign="top" style="line-height:inherit;border-collapse:collapse;vertical-align:top">
                                <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;text-align: center;padding:0 60px 30px;">
                                    <table cellpadding="0" cellspacing="0" style="margin: 0 auto;text-align: center;">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <a href="{{ $url }}" style="display:block;background: #ED4763;border-radius: 5.06182px;font-family: 'Roboto',Arial,sans-serif;font-style: normal;font-weight: 500;font-size: 13px;line-height: 11px;text-align: center;color: #FFFFFF;text-decoration: none;white-space: nowrap;padding: 12px 42px;">See Schedule</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr valign="top" style="line-height:inherit;border-collapse:collapse;vertical-align:top">
                                <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;font-family: 'Roboto',Arial,sans-serif;font-style: normal;font-weight: 400;font-size: 16px;line-height: 26px;color: #495057;padding: 0 60px 50px;text-align: left;">
                                    <p style="margin:0 0 25px;">Best wishes,</p>
                                    <p style="margin:25px 0 0;"><b>The CashMySkills Team</b></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @include('emails.footer');
                </td>
            </tr>
        </tbody>
    </table>
</div>