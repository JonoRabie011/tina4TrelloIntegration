<?php

class TrelloMember extends TrelloIntegration
{

    /**
     * If API Key or token is not set it will look for ENV variables -> <br>
     * <i>"TRELLO_API_KEY" & "TRELLO_API_TOKEN"</i>
     * @param string $APIKey
     * @param string $APIToken
     */
    public function __construct(string $APIKey = "", string $APIToken = "")
    {
        parent::__construct($APIKey, $APIToken);
    }

    /**
     * Function to information for a single member by member ID
     * @param string $memberId
     * @param string $boards If you pass in this param it will return board for a member
     *           <br> e.g <br>
     *            'all' or a comma-separated list of:
     *           <br>
     *           <hr>
     *           <br>- 'open' - Returns all boards that are open.
     *           <br>- 'closed' - Returns all boards that have been closed.
     *           <br>- 'members' - Returns all boards that have visibility set to Private.
     *           <br>- 'organization' - Returns all boards that have visibility set to Workspace.
     *           <br>- 'public' - Returns all boards that have visibility set to Public.
     *           <br>- 'starred' - Returns all boards that have been starred."
     * @return array|mixed
     */
    public function getMemberInfo(string $memberId, string $boards = ""): mixed
    {

        if(!empty($boards)) {
            $this->addQueryParam("boards", $boards);
        }

        return $this->sendRequest("/members/{$memberId}".$this->getParamString());
    }

    /**
     * Function to get all Workspaces for a specific member
     * @param string $memberId Member ID or member username
     * @param string $filter One of: all, members, none, public (Note: members filters to only private Workspaces)
     * @param string $organizationFields all or a comma-separated list of organization fields
     * @return array|mixed
     */
    public function getMemberOrganization(string $memberId, string $filter = "all", string $organizationFields = "all"): mixed
    {
        $this->addQueryParam("filter", $filter);
        $this->addQueryParam("fields", $organizationFields);

        return $this->sendRequest("/members/{$memberId}/organizations".$this->getParamString());
    }


    /**
     * Function to get List of boards that the user is a member of
     * @param string $memberId The ID or username of the member
     * @param string $filter Default all or a comma-separated list of: closed, members, open, organization, public, starred
     * @param string $boardFields Default all or id, name, desc, descData, closed, idMemberCreator, idOrganization, pinned,
     *                              url, shortUrl, prefs, labelNames, starred, limits, memberships, enterpriseOwned
     * @param string $fetchLists Default none or Which lists to include with the boards. One of: all, closed, none, open
     * @param bool $fetchOrganization Whether to include the Organization object with the Boards
     * @return array|mixed
     */
    public function getMemberBoards(string $memberId,
                                    string $boardFields = "all",
                                    string $filter = "all",
                                    string $fetchLists = "none",
                                    bool $fetchOrganization = false): mixed
    {
        $this->addQueryParams([
            "filter" => $filter,
            "fields" => $boardFields,
            "lists" => $fetchLists,
            "organization" => $fetchOrganization
        ]);

        return $this->sendRequest("/members/{$memberId}/boards".$this->getParamString());

    }

    public function getMemberNotifications($memberId)
    {

        return $this->sendRequest("/members/{$memberId}/notifications".$this->getParamString());
    }
}