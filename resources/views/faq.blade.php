<SCRIPT LANGUAGE="JavaScript">
    <!-- Begin
    <!--Free FAQ Page Generator: http://www.madsubmitter.com-->
        function showFAQ(form) {
            form.answer.value = form.question.options[form.question.selectedIndex].value;
        }
    // End -->
</SCRIPT>



<center>
    <form name=faqform>
        <table border=1 cellspacing=0 cellpadding=5>
            <tr bgcolor="#1B62A9">
                <td align=left><font face="verdana,arial" size="-1" color="#ffffff">
                        <b>FAQ</b></font></td>
            </tr>
            <tr bgcolor="#ffffcc"><td><font face="verdana,arial" size="-1"><br>
                        Browse the Frequently Asked Questions below and click for the answer.
                        <p>
                        <ul><select size=10 name=question onChange="javascript:showFAQ(this.form);">
                                <option value="2">&nbsp;&nbsp;&nbsp;-->&nbsp;&nbsp;1
                                <option value="4">&nbsp;&nbsp;&nbsp;-->&nbsp;&nbsp;3
                                <option value="6">&nbsp;&nbsp;&nbsp;-->&nbsp;&nbsp;5
                            </select>
                        </ul>
                        <p>
                            Answer:
                        <p>
                        <ul>
                            <textarea name="answer" rows=15 cols=50 wrap=virtual></textarea>
                        </ul>
                    </font>
                </td>
            </tr>
        </table>
    </form>
</center>
