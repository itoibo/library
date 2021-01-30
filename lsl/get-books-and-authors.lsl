key gAllAuthorsRequest;
key gOneAuthorRequest;

string API_URL = "https://library.bdx9.com/api";
integer MAIN_DIALOG_CHANNEL = 4315487;
integer AUTHOR_DIALOG_CHANNEL = 4315488;

handleAllAuthorsResponse(integer statusCode, list headers, string body)
{
    if (200 != statusCode) {
        llSay(PUBLIC_CHANNEL, "An unkown error occured.");
        return;
    }
    
    list authorsAsJson = llJson2List(body);
    string text = "Choose an author.\n";
    list buttons = [];
    integer i;
    for (i = 0; i < llGetListLength(authorsAsJson); i++) {
        string authorAsJson = llList2String(authorsAsJson, i);
        integer id = (integer)llJsonGetValue(authorAsJson, ["id"]);
        string firstName = llJsonGetValue(authorAsJson, ["first_name"]);
        string lastName = llJsonGetValue(authorAsJson, ["last_name"]);

        text += (string)id + ": " + firstName + " " + lastName + "\n";
        buttons = buttons + [(string)id];
    }

    llSay(0, text);
    llDialog(
        llGetOwner(),
        text,
        buttons,
        AUTHOR_DIALOG_CHANNEL
    );
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

    integer id = (integer)llJsonGetValue(body, ["id"]);
    string firstName = llJsonGetValue(body, ["first_name"]);
    string lastName = llJsonGetValue(body, ["last_name"]);

    llSay(PUBLIC_CHANNEL, firstName + " " + lastName);

    list booksAsJson = llJson2List(llJsonGetValue(body, ["books"]));
    llSay(PUBLIC_CHANNEL, "Books of this author:");
    integer i;
    for (i = 0; i < llGetListLength(booksAsJson); i++) {
        string booksAsJson = llList2String(booksAsJson, i);
        llSay(PUBLIC_CHANNEL, llJsonGetValue(booksAsJson, ["title"]));
    }
}


default
{
    state_entry()
    {
        llListen(MAIN_DIALOG_CHANNEL, "", llGetOwner(), "");
        llListen(AUTHOR_DIALOG_CHANNEL, "", llGetOwner(), "");
    }

    listen(integer channel, string name, key id, string message)
    {
        if (MAIN_DIALOG_CHANNEL == channel) {
            if ("List Authors" == message) {
                gAllAuthorsRequest = llHTTPRequest(API_URL + "/authors.php", [HTTP_METHOD, "GET"], "");
                return;
            }
        }

        if (AUTHOR_DIALOG_CHANNEL == channel) {
            gOneAuthorRequest = llHTTPRequest(API_URL + "/authors.php?id="+message, [HTTP_METHOD, "GET"], "");
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

    touch_start(integer number)
    {
        key agent = llDetectedKey(0);
        llDialog(
            agent,
            "What do you want to do?",
            ["List Authors", "Create Author"],
            MAIN_DIALOG_CHANNEL
        );
    }
}