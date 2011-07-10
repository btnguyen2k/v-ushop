<!-- FOOTER -->
<div id="footer">
    [:$MODEL.page.copyright:]
    <br/>
    Powered by <a href="http://code.google.com/p/vcatalog/">vCatalog ([:$MODEL.APP_VERSION:])</a>
    |
    Theme designed by <a href="mailto:gw@actamail.com">Gerhard Erbes</a>
    <!--
    | <a
    href="http://validator.w3.org/check?uri=referer"
    title="Validate code as W3C XHTML 1.1 Strict Compliant">W3C XHTML 1.1</a> | <a
    href="http://jigsaw.w3.org/css-validator/" title="Validate Style Sheet as W3C CSS 2.0 Compliant">W3C
    CSS 2.0</a>
    -->
</div>
<!-- //FOOTER -->
[:if isset($MODEL.debug):]
    [:assign var="_debug" value=$MODEL.debug:]
    <div id="debug">
        <table>
            <thead>
                <tr>
                    <th colspan="3">Memory Info</th>
                </tr>
                <tr>
                    <th>Usage</td>
                    <th>Peak</td>
                    <th>Limit</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="right">[:round($_debug->getMemoryUsageKb()):]K</td>
                    <td align="right">[:round($_debug->getMemoryPeakUsageKb()):]K</td>
                    <td align="right">[:$_debug->getMemoryLimit():]</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="3">SQL Info</th>
                </tr>
                <tr>
                    <th align="center">#</th>
                    <th>Query</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                [:assign var="_sqlTimeTotal" value=0:]
                [:foreach $_debug->getSqlLog() as $sqlLog:]
                    <tr>
                        <td align="right">[:$sqlLog@index+1:]</td>
                        <td align="left">[:$sqlLog[0]:]</td>
                        <td align="right">[:round($sqlLog[1],5):]</td>
                    </tr>
                    [:assign var="_sqlTimeTotal" value=$_sqlTimeTotal+$sqlLog[1]:]
                [:foreachelse:]
                    <tr>
                        <td colspan="3">No data</td>
                    </tr>
                [:/foreach:]
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th align="right">[:round($_sqlTimeTotal,5):]</th>
                </tr>
            </tfoot>
        </table>
    </div>
[:/if:]
