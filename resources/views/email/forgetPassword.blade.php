<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Vincent Grande">
    <style>
        .first-row {
            height: 170px;
            display: flex;
        }
        .first-row>div {
            display: flex;
            margin: auto
        }
        .second-row {
            height: auto;
            padding: 40px;
        }
        .third-row {
            height: 75px;
        }
        body {
            width: 600px;
            display: flex;
            flex-direction: column;
            margin: auto;
        }
        .img-mail {
            width: 185px;
            height: 69px;
            margin: auto;
        }
        .txt-header-mail {
            margin-right: 30px;
            color: white;
            font-size: 27px;
        }
        .txt-footer-mail {
            text-align: center;
            color: white;
            font-size: 18px;
        }
        .txt-footer-mail>a {
            color: white;
        }
        .txt-footer-mail>a:hover {
            text-decoration: underline;
        }
        .big-size-td {
            width: 60%;
            border: 1px solid black;
        }
        .little-size-td {
            width: 40%;
            border: 1px solid black;
        }
        .order-table {
            width: 100%;
        }
        .order-tr {
            display: flex;
        }
        .fnd-blanc {
            background-color: #ffffff;
        }
        .fnd-gris {
            background-color: #4a617d;
        }
    </style>
</head>
<body>
    <table class="table-mail">
        <tbody>
            <tr>
                <td class="fnd-gris first-row">
                    <div>
                        <p class="txt-header-mail">Password reset request</p>
                        <img class="img-mail"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUQAAABgCAYAAABloAtSAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAAFiUAABYlAUlSJPAAAAqESURBVHhe7d3fSxtZH8fx5w/r/9Ar/wAvCrnyRrwIWyiiF7I8tiBdBKXQUGrZlq4sKg8NRWUtWVwIhRS0KJaIMCBWIaRSIoHvMxNP7MyZc+ZXTpLd5f2F141OTnRqP5k5v+Y/9+4/EADAAyEQAUAhEAFAIRABQCEQAUAhEAFAIRABQCEQAUAhEAFAIRABQCEQAUAhEAFAIRABQCEQAUAhEAFAIRABQCEQAUAhEAFAIRABQCEQ/zbmZGZlSzZ29qX6bksWHpYNxwAYJgJxjCbn1+Xth0Npfr2WTldi1TlvyMq0+bUA3CMQR2l6SVY261I/bUnbEIDGah3K05KhLQDOEYjDVFqUn15sS+3Ak8tvKuAKVOdg3dw+AKcIRKfKMvXLlmzUT8Rr3ag4c1DdU3llfD8ALhGIA5qcX5PKzqEcnZv7Ad3UtdSfmd8fgDsEYl7TS/L4zf5tP2BH5dWg1b2R9ldPml/tV5WXf62afx4AzhCIqeZk5sW27DaCfkB3t8Gd1oUcNfalsrIkk6H3m3x5KG11TKTO6zIVOg6AewRiTFmmfl6Xt/WT3nQYZ9W9Fu+gIRtvKjKVOGpclrdf1Gsi5ckGo83AUBGId8oy+78TuXR1Gxyqztm+zOYIs6kPF+qV0Tr63Xw8ADcIxJ6yPP3YUrHjugoMiDxpyKV6dbg6n7fMxwNwgkAMPLP026VU51tLmo26VHf2pXZqu71uSe2J4T0TvZa6ad7iVUNmjccDcIFA9L0y9tkZqnMt3vGhVN+syYxhSd2M5Va3+T7/uuTKZ9MAzoXsPjIfD2BwBOL9Nakn3S1/86SWdbOF0p401csi9aVqPj7J76fqxdEqEq4AsiEQkwLxW951xKtSu1KvDdf3E6kYj0/gMlwBZEIg+my3zO2Pa8bjkzxtmPoSi6w0cRiuADIhEH0T7z2VNtFqN14bj0/064mYZu54HxbNxyewhuuK+XgAgyEQA4/qYozEQqO6VTkyrWk+25MJ4/EJHIarCxMPl42DSTGlRZnKtY9jMBk+umInk2A3ofk58/di5mTmSf73CH7n2ServuWUCfV2uduYXpKf2CB4LAjEHls/YpHVIWXZOFMvD1ehHWschutAyvLquD/qfSPN90uGYwJzstL4cSK9nQzBPb8nzX7qd/zzPW84xuRZQy7VuWl/2ZYZ0zF9Jf889t8jdX9JP5yf70n9zLJZR+damo09eZwY+MXbWPjzx/kL7lBG++8MAlExT3MptjrEvNLkRj79aj7ezmW4DkIb4DGuqy7HbvHTJ5Iblil6+5nWbD/+GH0v74MtpH2REfuE/tzSmlSt80m16rakZmpnoDa0D2b6i0eOQOyzTHMptDrEMtG7SJ+ku3AdhBaIweh75PuGlT5ZrvaWTCty/JBYMhyrifev+kH33HKbGekjtgRi6bXUTYNYCRUbdBu4DX1Cvn8Ow+1j6AjEPts0l9h//iy25NN39fpwFemTdBiuxSUFYlke+6Ed6evMeOu7cmDZPci/BU67VTQOONneN0Mgmtprn91Owr/t//MFu58ft9TvGm9n8DYIxHEjEO8syu65+juMVJGld7apPBdSzdsnaVtWONLtwGyBWJbZHa9QGN575LcZ6l9rHodD60J2U9owBmJQQR+hfnxaID7a1wbVbqS5s2oP5eml+OCSizYIxLEjEENm/zKOrIi3k3/EzzaVJ1+fZNnat9n7z1Jw1DM/cyDO+L+jHobV/2Y7VwvhzrLvJ7Jyfz1yVZ32HBlrIPoVG4xICcRYt4T/YZM4SGPgog0CcfwIxDDLNJdCq0MsU3my9ElOPKxI5V1Djq5sYXhbo9sOLB6Ir2Jh6F/VLWf84ChFuxQu65Xe1yNrwbt+GCSs244G4rW0I59l2kh4SiBuaN3HRaY1uWiDQBw/AjHCMs2l0GifZSpP179t1m8HS4uyEDyW4Pgi12MJRrcdmBaI3RstDFtSsw1oGEz9Eb6a8s9HP/hK25Hz3w9Kk2gg+sERnr7TKz/4+j9TYiDqK4IMt9SpXLQRIBDHjUCMsExzKfgHbr3d7Qbz0Oqy2zgd7Ol8hQZ8itACUa+rRo4135VoeGgDKJGBluCDyNJuLBD9r0081/pb+69PDEQ9hIr8W7toI0AgjhuBqLHtVl3oIU+WqTzuqtiAT35aIH73b1G1K9nO2V6mPrOJzfA5uZFPL7VjtKk43h/mW09TIAZf17dg6/1cXCEiIwJRZ9mtutCorm0qj8MazXZg2u8RXJnGblGzhOKiVMPZFDxn5tSTZsSFtMPdFparYFsg3ru/5F/lR6+6261of6MeVrH+vwKDaC7aIBDHj0CM0f8oVRVaHWKbyuOwRrIdmCEQ/a9PLNfF00Kx/blqD8WXlkGrlDrajIeLPRB9wQRp84QBv+KBGLsryLhaJsxFGwTi+BGIBuY5hMVWh9im8jirkSzvMgdi8L2g366/prhf5jW4tqcJZqirhixo7SUGYsBwBXtbhttZ0xxC63ptCxdtEIhjRyAajGI7MHdVtL8qD3sgBmKDGX5dftRCUesb7Jw1es+isdn9Eg68eF9jaiD6YvMke2U6X+b5nu3Teui52XMys7Il1YZ3e0sfW4fsog0CcdwIRJNRbAfmsAoN+OSSHIiBmd9OtFCMXiFFl+n5QZC2XllbyaLfgmYJxCCkoscFZfkASbzNNlfsA3LgNgjEcSMQjSy7VRd6yJNtKo/DGvoyPi0QLe8XuyK763fVPhQyrFUOREM0eu6zBWJAH2RJuKKeXpfaefwqz1yWdgZqg91uxo1AtIhfWdxW8535+CS2qTzOaujbgS3KxumP/+SXf9onTEdC8a7vryK7X9XXkgJJF9krUfsdw2u80wYwwlduQTuJcybnZGGzIU3b/NDujVwe+7fBiUsUi7fxNLStWee4mumDA+4QiDaWvr9Cq0NsU3mcVY6QKSzY1XpVZjPsUH27Q3S/36wv2LF6Nf9O0NNLvV1iTDt1m9/HIthd29KOlXrN3U41mXfnDinQxuS8f9zPi4ThGBCINk63A9P7htzX6NY1A/9eBKKVy+3Ahj2wMqoVK8C/G4GYwLodWK6dTEwjnY6r0FZTAHQEYhLb5qypD3nqzzcLNm9QrxlaXdu3zgeQC4GYyPIogCCEXkY7xyfn16SycyhH55YnrQ2jOhdS034OAMURiCn0Rfvhap970jxr5drDcODqXIt3HDyno1L4OcEAzAjEFEOfQ5hW3Rs/eE+k9m5LFnh4OTBUBGKaoc8hjFendSGf6tuywlw0YKQIxFTDn0Mo31rSPGjI2xfL3AYDY0QgZmB/8l3B6lzL5emh7G6u51s5AWCoCMQsCm5sele9fsBTqe9syeMiy78AjASBmEl8W/q0uu0H3JPKL/QDAv8UBGJWpTXZ9RJCMZgOc9CQDabDAP9YBGIuZZl6vif14/4DkU6ktrmefwcXAH9LBCIAKAQiACgEIgAoBCIAKAQiACgEIgAoBCIAKAQiACgEIgAoBCIAKAQiACgEIgAoBCIAKAQiACgEIgAoBCIAKAQiACgEIgAoBCIAKAQiACgEIgAoBCIAKAQiACgEIgAoBCIAKAQiACgEIgD0PJD/A6SGBTaIM+bQAAAAAElFTkSuQmCC"
                            alt="Logo KANCCI">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="fnd-blanc second-row">
                    <h1>Forget Password Email</h1>
   
                    You can reset password from bellow link:
                    <a href="{{ route('reset.password.get', $token) }}">Reset Password</a>
                    <br><br>
                   
                </td>
            </tr>
            <tr>
                <td class="fnd-gris third-row">
                    <p class="txt-footer-mail">Find us on <a href="{{route('index')}}">KANCCI</a></p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>