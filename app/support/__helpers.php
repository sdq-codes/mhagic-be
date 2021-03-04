<?php

use App\Exceptions\RecordNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

function custom_url(string $base, string $path = null, array $parameters = null, bool $secure = true): string
{
    $uri = new \GuzzleHttp\Psr7\Uri($base);
    # create the URI
    $path = $path ?: '/';
    # for situations where NULL was passed as the path - we assume the base
    if (!empty($path) && !(is_string($path) || is_array($path))) {
        throw new InvalidArgumentException('path should either be a string or an array');
    }
    if (!empty($path)) {
        $path = is_string($path) ? $path : implode('/', $path);
        $uri = $uri->withPath(starts_with($path, '/') ? $path : '/'.$path);
    }
    if (!empty($parameters)) {
        $uri = $uri->withQuery(http_build_query($parameters));
    }
    if ($secure) {
        $uri = $uri->withScheme('https');
    }
    return (string) $uri;
}

function cdn(string $path, bool $secure = true)
{
    $base = config('app.cdn_url', config('app.url'));
    # we get the base URL first
    $secure = app()->environment() === 'production' ? $secure : false;
    # on local, we turn secure mode off
    return custom_url($base, $path, null, $secure);
}

/**
 * @param string|array $path
 * @param array $parameters
 * @param bool  $secure
 *
 * @return string
 */
function web_url($path = null, array $parameters = [], bool $secure = true): string
{
    $base = config('app.url', 'http://localhost');
    # we get the base URL first
    return custom_url($base, $path, $parameters, $secure);
}

/**
 * @param null  $path
 * @param array $parameters
 * @param bool  $secure
 *
 * @return string
 */
function site_url($path = null, array $parameters = [], bool $secure = true): string
{
    $base = config('app.site_url', config('app.url'));
    # we get the base URL first
    return custom_url($base, $path, $parameters, $secure);
}

function validation_errors_to_messages(ValidationException $exception)
{
    $dependentFieldChecks = [
        'required_if',
        'required_unless',
        'required_with',
        'required_with_all',
        'required_without',
        'required_without_all'
    ];
    # checks that have dependent fields
    $messages = [];
    $errors = [];
    foreach ($exception->validator->failed() as $field => $failures) {
        foreach ($failures as $rule => $data) {
            $errors[$field][$rule] = is_array($data) ? implode(', ', $data) : $data;
        }
    }
    foreach ($exception->errors() as $field => $failures) {
        $fieldErrors = $errors[$field] ?? [];
        # get the specific errors for the field -- we'll need this to get additional validation data
        foreach ($failures as $id) {
            $components = explode('.', $id);
            # split up the id
            $checkName = count($components) > 1 ? $components[1] : $components[0];
            # we parse out the check name from the id
            $errorKey = str_replace('_', '', Str::title($checkName));
            # now we see if we got it
            $attributes = [
                'attribute' => $field,
                'values' => $fieldErrors[$errorKey],
                strtolower($checkName) => $fieldErrors[$errorKey]
            ];
            if (in_array($checkName, $dependentFieldChecks)) {
                # this field is one of those that has dependencies
                $split = explode(',', $fieldErrors[$errorKey]);
                $additional = ['other' => $split[0]];
                if (count($split) === 2) {
                    $additional['value'] = trim($split[1]);
                } elseif (count($split) > 2) {
                    unset($split[0]);
                    $additional['value'] = implode(',', $split);
                }
                $attributes = array_merge($attributes, $additional);
            }
            # we set the attributes
            if (isset($messages[$field]) && !is_array($messages[$field])) {
                $messages[$field] = (array) $messages[$field];
            }
            if (!empty($messages[$field]) && is_array($messages[$field])) {
                $messages[$field][] = trans($id, $attributes, 'en');
            } else {
                $messages[$field] = trans($id, $attributes, 'en');
            }
        }
    }
    return $messages;
}



if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}




