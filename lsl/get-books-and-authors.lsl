key gAllAuthorsRequest;
key gOneAuthorRequest;

string API_URL = "https://library.bdx9.com/api";


handleAllAuthorsResponse(integer statusCode, list headers, string body)
{
    if (200 != statusCode) {
        llSay(PUBLIC_CHANNEL, "An unkown error occured.");
        return;
    }
    
    llSay(PUBLIC_CHANNEL, body);
}


handleOneAuthorResponse(integer statusCode, list headers, string body)
{
    if (404 == statusCode) {
        llSay(PUBLIC_CHANNEL, "This author doesn't exist.");
        return;
    }
    if (200 != statusCode) {
        llSay(PUBLIC_CHANNEL, "An unkown error occured.");
        return;
    }

    llSay(PUBLIC_CHANNEL, body);
}



default
{
    state_entry()
    {
        llListen(PUBLIC_CHANNEL, "", llGetOwner(), "");
    }

    listen(integer channel, string name, key id, string message)
    {
        list messageParts = llParseString2List(message, [" "], []);

        string filter = llList2String(messageParts, 0);
        if ("endpoint" != filter) {
            return;
        }

        string endpoint = llList2String(messageParts, 1);

        if ("all-authors" == endpoint) {
            llOwnerSay("we retrive all authors");
            gAllAuthorsRequest = llHTTPRequest(API_URL + "/authors.php", [HTTP_METHOD, "GET"], "");
        }

        if ("one-author" == endpoint) {
            llOwnerSay("we retrive one author");
            if (3 != llGetListLength(messageParts)) {
                llSay(PUBLIC_CHANNEL, "You have to provide an id.");
                return;
            }
            integer id = llList2Integer(messageParts, 2);
            gOneAuthorRequest = llHTTPRequest(API_URL + "/authors.php?id=" + (string)id, [HTTP_METHOD, "GET"], "");
        }
    }
    
    http_response(key request, integer statusCode, list headers, string body)
    {
        //llSay(PUBLIC_CHANNEL, "we got a response");
        llSay(PUBLIC_CHANNEL, "Response code: " + (string)statusCode);
        //llSay(PUBLIC_CHANNEL, "Response body: " + body);
        
        if (gAllAuthorsRequest == request) {
            handleAllAuthorsResponse(statusCode, headers, body);
        }
        
        if (gOneAuthorRequest == request) {
            handleOneAuthorResponse(statusCode, headers, body);
        }
        
    }
}