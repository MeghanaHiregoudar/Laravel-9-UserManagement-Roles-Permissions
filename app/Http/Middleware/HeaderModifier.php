<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HeaderModifier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        // $response->headers->remove('server');
        // $response->headers->set('server','*****');

        header_remove('server');
        header_remove('x-powered-by');
        // Add Strict-Transport-Security header
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');  //Enforces the use of HTTPS

        // Add Content-Security-Policy header
        // Prevents various types of attacks like XSS by allowing the browser to understand from where resources can be loaded.
        // $csp = "default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; style-src 'self' https://maxcdn.bootstrapcdn.com";
        // $response->headers->set('Content-Security-Policy', $csp);
        // $response->header('Content-Security-Policy', "default-src 'self';");
        $response->header('Content-Security-Policy', 'frame-ancestors none');

        // Set X-Content-Type-Options header      
        $response->header('X-Content-Type-Options', 'nosniff');//: Prevents browsers from interpreting files as a different MIME type than declared by the server.

        // Set x-permitted-cross-domain-policies header      
        $response->header('X-Permitted-Cross-Domain-Policies', 'none'); //Restricts which cross-domain policies are allowed.

        // Set Cross-Origin-Embedder-Policy header
        $response->header('Cross-Origin-Embedder-Policy', 'require-corp'); //Controls whether a document is allowed to be embedded.
        // Set Cross-Origin-Resource-Policy header
        $response->header('Cross-Origin-Resource-Policy', 'same-origin');  //Controls whether a resource can be shared based on the requesting document’s origin.
        // Set Permissions-Policy header
        $response->header('Permissions-Policy', 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()'); //Controls which browser features the page can use.
        // Set X-Frame-Options header to DENY
        $response->header('X-Frame-Options', 'DENY');  //Prevents a webpage from being embedded within an iframe.
        // Set Referrer-Policy header to DENY
        $response->header('Referrer-Policy', 'no-referrer');  //Controls what information is included in the Referer header.
       
        // Set Clear-Site-Data header to DENY
        $headerValue = '"cache", "cookies", "storage"';
        $response->header('Clear-Site-Data', $headerValue);
        
        return $response;
    }
}
