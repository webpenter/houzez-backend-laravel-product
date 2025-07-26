<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key
    |--------------------------------------------------------------------------
    |
    | This key is used to authenticate with the OpenAI API.
    | You can get your API key from https://platform.openai.com/account/api-keys
    |
    */
    'openai_api_key' => env('OPENAI_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Claude API Key
    |--------------------------------------------------------------------------
    |
    | This key is used to authenticate with the Claude API.
    |
    */
    'claude_api_key' => env('CLAUDE_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Model
    |--------------------------------------------------------------------------
    |
    | The default model to use for generating documentation.
    |
    */
    'default_model' => env('DOCUDOODLE_MODEL', 'gpt-4o'),

    /*
    |--------------------------------------------------------------------------
    | Maximum Tokens
    |--------------------------------------------------------------------------
    |
    | The maximum number of tokens to use for API calls.
    |
    */
    'max_tokens' => env('DOCUDOODLE_MAX_TOKENS', 10000),

    /*
    |--------------------------------------------------------------------------
    | Default Extensions
    |--------------------------------------------------------------------------
    |
    | The default file extensions to process.
    |
    */
    'default_extensions' => ['php', 'yaml', 'yml'],

    /*
    |--------------------------------------------------------------------------
    | Default Skip Directories
    |--------------------------------------------------------------------------
    |
    | The default directories to skip during processing.
    |
    */
    'default_skip_dirs' => ['vendor/', 'node_modules/', 'tests/', 'cache/'],

    /*
    |--------------------------------------------------------------------------
    | Ollama Settings
    |--------------------------------------------------------------------------
    |
    | Settings for the Ollama API which runs locally.
    |
    | host: The host where Ollama is running (default: localhost)
    | port: The port Ollama is listening on (default: 11434)
    |
    */
    'ollama_host' => env('OLLAMA_HOST', 'localhost'),
    'ollama_port' => env('OLLAMA_PORT', '11434'),

    /*
    |--------------------------------------------------------------------------
    | Gemini API Key
    |--------------------------------------------------------------------------
    |
    | This key is used to authenticate with the Gemini API.
    |
    */
    'gemini_api_key' => env('GEMINI_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Azure OpenAI Settings
    |--------------------------------------------------------------------------
    |
    | Settings for Azure OpenAI integration.
    |
    | endpoint: Your Azure OpenAI resource endpoint
    | api_key: Your Azure OpenAI API key
    | deployment: Your Azure OpenAI deployment ID
    | api_version: Azure OpenAI API version (default: 2023-05-15)
    |
    */
    'azure_endpoint' => env('AZURE_OPENAI_ENDPOINT', ''),
    'azure_api_key' => env('AZURE_OPENAI_API_KEY', ''),
    'azure_deployment' => env('AZURE_OPENAI_DEPLOYMENT', ''),
    'azure_api_version' => env('AZURE_OPENAI_API_VERSION', '2023-05-15'),

    /*
    |--------------------------------------------------------------------------
    | Default API Provider
    |--------------------------------------------------------------------------
    |
    | The default API provider to use for generating documentation.
    | Supported values: 'openai', 'ollama', 'claude', 'gemini', 'azure'
    |
    */
    'default_api_provider' => env('DOCUDOODLE_API_PROVIDER', 'openai'),

    /*
    |--------------------------------------------------------------------------
    | Jira Settings
    |--------------------------------------------------------------------------
    |
    | Settings for Jira integration.
    |
    | enabled: Enable/disable Jira integration
    | host: Your Jira instance URL (e.g., https://your-domain.atlassian.net)
    | api_token: Your Jira API token
    | email: Your Atlassian account email
    | project_key: The Jira project key where documentation should be created
    | issue_type: The type of issue to create (default: 'Documentation')
    |
    */
    'jira' => [
        'enabled' => env('DOCUDOODLE_JIRA_ENABLED', false),
        'host' => env('JIRA_HOST', ''),
        'api_token' => env('JIRA_API_TOKEN', ''),
        'email' => env('JIRA_EMAIL', ''),
        'project_key' => env('JIRA_PROJECT_KEY', ''),
        'issue_type' => env('JIRA_ISSUE_TYPE', 'Documentation'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Confluence Settings
    |--------------------------------------------------------------------------
    |
    | Settings for Confluence integration.
    |
    | enabled: Enable/disable Confluence integration
    | host: Your Confluence instance URL (e.g., https://your-domain.atlassian.net)
    | api_token: Your Confluence API token
    | email: Your Atlassian account email
    | space_key: The Confluence space where documentation should be created
    | parent_page_id: Optional parent page ID under which to create documentation
    |
    */
    'confluence' => [
        'enabled' => env('DOCUDOODLE_CONFLUENCE_ENABLED', false),
        'host' => env('CONFLUENCE_HOST', ''),
        'api_token' => env('CONFLUENCE_API_TOKEN', ''),
        'email' => env('CONFLUENCE_EMAIL', ''),
        'space_key' => env('CONFLUENCE_SPACE_KEY', ''),
        'parent_page_id' => env('CONFLUENCE_PARENT_PAGE_ID', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure the caching mechanism to skip unchanged files.
    |
    | use_cache: Enable or disable caching (default: true).
    | cache_file_path: Absolute path to the cache file. If null or empty,
    |                  it defaults to '.docudoodle_cache.json' inside the output directory.
    | bypass_cache: Force regeneration of all documents even if they haven't changed.
    |              This will still update the cache file with new hashes (default: false).
    |
    */
    'use_cache' => env('DOCUDOODLE_USE_CACHE', true),
    'cache_file_path' => env('DOCUDOODLE_CACHE_PATH', null),
    'bypass_cache' => env('DOCUDOODLE_BYPASS_CACHE', false),

    /*
    |--------------------------------------------------------------------------
    | Prompt Template
    |--------------------------------------------------------------------------
    |
    | The path to the prompt template file.
    |
    */
    'prompt_template' => env('DOCUDOODLE_PROMPT_TEMPLATE', __DIR__.'/../../resources/templates/default-prompt.md'),
];
