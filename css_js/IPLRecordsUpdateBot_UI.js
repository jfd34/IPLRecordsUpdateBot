
// Function for setting a CSS property on a given element
function setCSSProperty(element, name, value) {
    // Parse the style attribute
    var styleAttr = element.getAttribute('style');
 
    // Prevent a missing style attribute throwing an exception
    if ( ! styleAttr ) {
        element.setAttribute('style', name + ': ' + value);
        return;
    }
 
    var styleProperties = styleAttr.split(/\s*;\s*/);
 
    for ( var i = 0; i < styleProperties.length; i++ ) {
        var stylePropRegex = /^([a-z0-9\-]+)\s*\:\s*(.*)\s*$/i;
        var stylePropParts = stylePropRegex.exec(styleProperties[i]);
        styleProperties[stylePropParts[1]] = stylePropParts[2];
        delete styleProperties[i];
    }
 
    styleProperties[name] = value;
 
    // Change it back to an indexed array
    var i = 0;
    for ( var propName in styleProperties ) {
        styleProperties[i] = propName + ': ' + styleProperties[propName];
        i++;
        delete styleProperties[propName];
    }
 
    element.setAttribute('style', styleProperties.join('; '));
}


// Add click events to the buttons

document.getElementById('resumebutton').addEventListener('click', function(e) {
    resumeEdit();
});

document.getElementById('submitbutton').addEventListener('click', function(e) {
    submitForm();
});

document.getElementById('selectallbutton').addEventListener('click', function(e) {
    selectAllOptions();
});

document.getElementById('deselectallbutton').addEventListener('click', function(e) {
    deselectAllOptions();
});

// Show the edit failed box if the backup file exists
var backupFileRequest = new XMLHttpRequest();
backupFileRequest.open('GET', 'status/edit_failed_backup.txt', false);
backupFileRequest.send();
if ( backupFileRequest.status == 200 ) {
    setCSSProperty(document.getElementById('lasteditfailed'), 'display', 'block');
}
 
function selectAllOptions() {
    var checkboxes = document.getElementById('optionstable').getElementsByTagName('input');
 
    for ( var i = 0; i < checkboxes.length; i++ ) {
        checkboxes[i].checked = true;
    }
}
 
function deselectAllOptions() {
    var checkboxes = document.getElementById('optionstable').getElementsByTagName('input');
 
    for ( var i = 0; i < checkboxes.length; i++ ) {
        checkboxes[i].checked = false;
    }
}
 
 
function submitForm() {
 
    var checkboxes = document.getElementById('optionstable').getElementsByTagName('input');
    var statusBox = document.getElementById('status');
 
    var statsToUpdate = [];
    for ( var i = 0; i < checkboxes.length; i++ ) {
        if ( checkboxes[i].checked === true ) {
            statsToUpdate.push(checkboxes[i].getAttribute('name'))
        }
    }
 
    if ( statsToUpdate.length == 0 ) {
        alert('No stats selected to update');
        return;
    }
 
    // Change the status box
    setCSSProperty(statusBox, 'border-color', '#FFB700');
    setCSSProperty(statusBox, 'background-color', '#FFFFBB');
    statusBox.getElementsByTagName('td')[1].innerHTML = 'Updating... 0 of ' + statsToUpdate.length + ' completed (0 succeeded, 0 failed)';
    statusBox.getElementsByTagName('td')[0].getElementsByTagName('img')[0].setAttribute('src', 'Images/Ambox_clock_yellow.svg');
 
    // Remove any unselected checkboxes
    for ( var i = 0; i < checkboxes.length; i++ ) {
        if ( checkboxes[i].checked === false ) {
            setCSSProperty(checkboxes[i].parentNode.parentNode, 'display', 'none');
        }
    }
 
    // Disable the form buttons
    for ( var i = 0; i < document.getElementById('formbuttons').getElementsByTagName('input').length; i++ ) {
        document.getElementById('formbuttons').getElementsByTagName('input')[i].disabled = true;
    }
 
    // Hide the last edit failed box if any
    setCSSProperty(document.getElementById('lasteditfailed'), 'display', 'none');
 
    // Send the request to update.php
    var updateXHR = new XMLHttpRequest();
    
    updateXHR.addEventListener('readystatechange', function(e) {
        updateXHR_readyStateChange();
    });
    
    function updateXHR_readyStateChange() {
 
        if ( updateXHR.readyState == 4 ) {
            
            var responseText = updateXHR.responseText;
            
            // Run the update status function for the last time
            updateStatus();
            updateErrors();
            clearInterval(updateStatusInterval);
 
            // If the PHP script terminates befor the updating starts, it is most likely an error
            if ( statsUpdateCounters.totalCount == 0 ) {
                setCSSProperty(statusBox, 'border-color', '#FF0000');
                setCSSProperty(statusBox, 'background-color', '#FF8585');
                statusBox.getElementsByTagName('td')[1].innerHTML = 'Failed before update' + (updateXHR.responseText ? ('<br />Error: ' + updateXHR.responseText) : '');
                statusBox.getElementsByTagName('td')[0].getElementsByTagName('img')[0].setAttribute('src', 'Images/Crystal_128_error.svg');
            }
            
            else if ( responseText.substr(0, 8) == '#success' ) {  // Edit successful
                var revisionIDRegex = /#success\|(\d+)\-(\d+)/;
                var revisionIDMatch = revisionIDRegex.exec(responseText);
 
                setCSSProperty(statusBox, 'border-color', '#00CC00');
                setCSSProperty(statusBox, 'background-color', '#85FF85');
 
                var statusMsg = statusBox.getElementsByTagName('td')[1];
                statusMsg.innerHTML = statusMsg.innerHTML.replace(/Committing edit\.\.\./, 'Edit successful (<a href="https://en.wikipedia.org/w/index.php?diff=' + revisionIDMatch[2] + '&amp;oldid=' + revisionIDMatch[1] + '" target="_blank">diff</a>)');
 
                statusBox.getElementsByTagName('td')[0].getElementsByTagName('img')[0].setAttribute('src', 'Images/Dialog-apply.svg');
            }
            
            else if ( responseText.substr(0, 6) == '#error' ) {  // Edit failed
                
                var errorMessageRegex = /#error\|(.*)$/;
                var errorMessage = errorMessageRegex.exec(responseText)[1];
                
                setCSSProperty(statusBox, 'border-color', '#FF0000');
                setCSSProperty(statusBox, 'background-color', '#FF8585');
 
                var statusMsg = statusBox.getElementsByTagName('td')[1];
                statusMsg.innerHTML = statusMsg.innerHTML.replace(/Committing edit\.\.\./, 'Edit failed');
                statusMsg.innerHTML += '<br />Error: ' + errorMessage;
                statusBox.getElementsByTagName('td')[0].getElementsByTagName('img')[0].setAttribute('src', 'Images/Crystal_128_error.svg');
                
            }
 
        }
 
    }
    
    updateXHR.open('GET', 'main.php?stats=' + statsToUpdate.join('|'), true);
    updateXHR.send();
 
    var statsUpdateCounters = {
 
        '_totalCount': 0,
        '_successCount': 0,
        '_failedCount': 0,
        
        get totalCount() {
            return this._totalCount;
        },
        
        set totalCount(x) {
            this._totalCount = x;
            var statusMsg = statusBox.getElementsByTagName('td')[1];
            statusMsg.innerHTML = statusMsg.innerHTML.replace(/\d+ (of \d+ completed)/, x + ' $1');
 
            if ( x == statsToUpdate.length ) {
                statusMsg.innerHTML = statusMsg.innerHTML.replace(/Updating\.\.\. \d+ of \d+ completed \((.*?)\)/, 'All ' + x + ' updates completed ($1)<br />Committing edit...');
            }
        },
        
        get successCount() {
            return this._totalCount;
        },
        
        set successCount(x) {
            this._successCount = x;
            var statusMsg = statusBox.getElementsByTagName('td')[1];
            statusMsg.innerHTML = statusMsg.innerHTML.replace(/\d+ succeeded\,/, x + ' succeeded,');
        },
        
        get failedCount() {
            return this._totalCount;
        },
        
        set failedCount(x) {
            this._failedCount = x;
            var statusMsg = statusBox.getElementsByTagName('td')[1];
            statusMsg.innerHTML = statusMsg.innerHTML.replace(/\d+ failed\)/, x + ' failed)');
        },
 
    }
 
    function updateStatus() {
 
        var statusXHR = new XMLHttpRequest()
        statusXHR.open('GET', 'status/status.txt', false);
        statusXHR.send();
 
        if ( statusXHR.responseText == '' || ! (statusXHR.status == 200 || statusXHR.status == 304) ) {
            return;
        }
 
        var statusFile = statusXHR.responseText.split('\r\n');
        var line, totalCount = 0, successCount = 0, failedCount = 0;
        
        for ( var i = 0; i < statusFile.length; i++ ) {
            
            line = statusFile[i];
            if ( line == '' ) continue;
            
            var lineParts = line.split('|');
            var statName = lineParts[0], result = lineParts[1];
            
            totalCount++;
            
            if ( result == 0 ) {
                markStatAsFailed(statName);
                failedCount++;
            }
            else {
                markStatAsSuccess(statName);
                successCount++;
            }
            
        }
        
        statsUpdateCounters.totalCount = totalCount;
        statsUpdateCounters.successCount = successCount;
        statsUpdateCounters.failedCount = failedCount;

 
        function markStatAsSuccess(name) {
            var statRow = document.getElementById('stats__' + name);
            statRow.setAttribute('class', 'success');
            statRow.getElementsByTagName('td')[1].innerHTML = '<img src="Images/Dialog-apply.svg" style="height: 15px; vertical-align: middle; padding-right: 5px" />Success';
        }
        
        function markStatAsFailed(name) {
            var statRow = document.getElementById('stats__' + name);
            statRow.setAttribute('class', 'failed');
            statRow.getElementsByTagName('td')[1].innerHTML = '<img src="Images/Crystal_128_error.svg" style="height: 15px; vertical-align: middle; padding-right: 5px" />Failed';
        }
 
    }
 
    function updateErrors() {
 
        var errorsXHR = new XMLHttpRequest();
        errorsXHR.open('GET', 'status/error_log.txt', false);
        errorsXHR.send();
 
        if ( errorsXHR.responseText == '' || ! (errorsXHR.status == 200 || errorsXHR.status == 304) ) {
            return;
        }
 
        var errorsFile = errorsXHR.responseText.split('\r\n');
        var errorTable = document.getElementById('errortable');
        
        // Clear the error table before filling it
        while ( errorTable.getElementsByTagName('tr').length > 1 ) {
            errorTable.removeChild(errorTable.getElementsByTagName('tr')[1]);  // Do not remove the header row
        }
        
        for ( var i = 0; i < errorsFile.length; i++ ) {
            var errorRegex = /^CODE:(.*?)|MESSAGE:(.*?)|FILE:(.*?)|LINE:(.*?)$/
            var errorParts = errorRegex.exec(errorsFile[i]);
            
            addErrorMessage(errorParts[0], errorParts[1], errorParts[2], errorParts[3]);
        }
        
        function addErrorMessage(type, message, file, line) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = '<td>' + type + '</td><td>' + message + '</td><td>' + file  + '</td><td>' + line + '</td>';
            errorTable.appendChild(newRow);
        }
 
    }
 
    var updateStatusInterval = setInterval(
        function() {
            updateStatus();
            updateErrors();
        },
        5000
    );
 
}
 
 
function resumeEdit() {
 
    setCSSProperty(document.getElementById('lasteditfailed'), 'display', 'none');
 
    var statusBox = document.getElementById('status');
 
    setCSSProperty(statusBox, 'border-color', '#FFB700');
    setCSSProperty(statusBox, 'background-color', '#FFFFBB');
    statusBox.getElementsByTagName('td')[0].getElementsByTagName('img')[0].setAttribute('src', 'Images/Ambox_clock_yellow.svg');
    statusBox.getElementsByTagName('td')[1].innerHTML = 'Resuming...';
 
    for ( var i = 0; i < document.getElementById('formbuttons').getElementsByTagName('input').length; i++ ) {
        document.getElementById('formbuttons').getElementsByTagName('input')[i].disabled = true;
    }
 
    // Send the request
    var updateXHR = new XMLHttpRequest();
    updateXHR.addEventListener('readystatechange', function(e) {
        updateXHR_readyStateChange();
    });
    
    function updateXHR_readyStateChange() {
 
        if ( updateXHR.readyState == 4 ) {
            
            updateErrors();
            clearInterval(updateStatusInterval);
            
            var responseText = updateXHR.responseText;
            
            if ( responseText.substr(0, 8) == '#success' ) {  // Edit successful
                var revisionIDRegex = /#success\|(\d+)\-(\d+)/;
                var revisionIDMatch = revisionIDRegex.exec(responseText);
 
                setCSSProperty(statusBox, 'border-color', '#00CC00');
                setCSSProperty(statusBox, 'background-color', '#85FF85');
 
                var statusMsg = statusBox.getElementsByTagName('td')[1];
                statusMsg.innerHTML = statusMsg.innerHTML.replace(/Committing edit\.\.\./, 'Edit successful (<a href="https://en.wikipedia.org/w/index.php?diff=' + revisionIDMatch[2] + '&amp;oldid=' + revisionIDMatch[1] + '" target="_blank">diff</a>)');
 
                statusBox.getElementsByTagName('td')[0].getElementsByTagName('img')[0].setAttribute('src', 'Images/Dialog-apply.svg');
            }
            
            else if ( responseText.substr(0, 6) == '#error' ) {  // Edit failed
                
                var errorMessageRegex = /#error\|(.*)$/;
                var errorMessage = errorMessageRegex.exec(responseText)[1];
                
                setCSSProperty(statusBox, 'border-color', '#FF0000');
                setCSSProperty(statusBox, 'background-color', '#FF8585');
 
                var statusMsg = statusBox.getElementsByTagName('td')[1];
                statusMsg.innerHTML = statusMsg.innerHTML.replace(/Committing edit\.\.\./, 'Edit failed');
                statusMsg.innerHTML += '<br />Error: ' + errorMessage;
                statusBox.getElementsByTagName('td')[0].getElementsByTagName('img')[0].setAttribute('src', 'Images/Crystal_128_error.svg');
                
            }
 
        }
 
    }
    
    updateXHR.open('GET', 'main.php?resume=1', true);
    updateXHR.send();
 
    function updateErrors() {
 
        var errorsXHR = new XMLHttpRequest();
        errorsXHR.open('GET', 'status/error_log.txt', false);
        errorsXHR.send();
 
        if ( errorsXHR.responseText == '' || ! (errorsXHR.status == 200 || errorsXHR.status == 304) ) {
            return;
        }
 
        var errorsFile = errorsXHR.responseText.split('\r\n');
        var errorTable = document.getElementById('errortable');
        
        // Clear the error table before filling it
        while ( errorTable.getElementsByTagName('tr').length > 1 ) {
            errorTable.removeChild(errorTable.getElementsByTagName('tr')[1]);  // Do not remove the header row
        }
        
        for ( var i = 0; i < errorsFile.length; i++ ) {
            if ( errorsFile[i] == '' ) continue;
            
            var errorRegex = /^CODE\:(.*?)\|MESSAGE\:(.*?)\|FILE\:(.*?)\|LINE\:(.*?)$/
            var errorParts = errorRegex.exec(errorsFile[i]);
            
            addErrorMessage(errorParts[1], errorParts[2], errorParts[3], errorParts[4]);
        }
        
        function addErrorMessage(type, message, file, line) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = '<td>' + type + '</td><td>' + message + '</td><td>' + file  + '</td><td>' + line + '</td>';
            errorTable.appendChild(newRow);
        }
 
    }
 
    var updateStatusInterval = setInterval(
        function() {
            updateErrors();
        },
        5000
    );
 
}