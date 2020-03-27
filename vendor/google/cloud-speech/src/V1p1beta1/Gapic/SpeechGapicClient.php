<?php
/*
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/speech/v1p1beta1/cloud_speech.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Speech\V1p1beta1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Speech\V1p1beta1\LongRunningRecognizeRequest;
use Google\Cloud\Speech\V1p1beta1\LongRunningRecognizeResponse;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognizeRequest;
use Google\Cloud\Speech\V1p1beta1\RecognizeResponse;
use Google\Cloud\Speech\V1p1beta1\StreamingRecognizeRequest;
use Google\Cloud\Speech\V1p1beta1\StreamingRecognizeResponse;
use Google\LongRunning\Operation;

/**
 * Service Description: Service that implements Google Cloud Speech API.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $speechClient = new Google\Cloud\Speech\V1p1beta1\SpeechClient();
 * try {
 *     $encoding = Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding::FLAC;
 *     $sampleRateHertz = 44100;
 *     $languageCode = 'en-US';
 *     $config = new Google\Cloud\Speech\V1p1beta1\RecognitionConfig();
 *     $config->setEncoding($encoding);
 *     $config->setSampleRateHertz($sampleRateHertz);
 *     $config->setLanguageCode($languageCode);
 *     $uri = 'gs://bucket_name/file_name.flac';
 *     $audio = new Google\Cloud\Speech\V1p1beta1\RecognitionAudio();
 *     $audio->setUri($uri);
 *     $response = $speechClient->recognize($config, $audio);
 * } finally {
 *     $speechClient->close();
 * }
 * ```
 *
 * @experimental
 */
class SpeechGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.speech.v1p1beta1.Speech';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'speech.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
    ];

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/speech_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/speech_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/speech_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/speech_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();

        return $operation;
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'speech.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     * @experimental
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /**
     * Performs synchronous speech recognition: receive results after all audio
     * has been sent and processed.
     *
     * Sample code:
     * ```
     * $speechClient = new Google\Cloud\Speech\V1p1beta1\SpeechClient();
     * try {
     *     $encoding = Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding::FLAC;
     *     $sampleRateHertz = 44100;
     *     $languageCode = 'en-US';
     *     $config = new Google\Cloud\Speech\V1p1beta1\RecognitionConfig();
     *     $config->setEncoding($encoding);
     *     $config->setSampleRateHertz($sampleRateHertz);
     *     $config->setLanguageCode($languageCode);
     *     $uri = 'gs://bucket_name/file_name.flac';
     *     $audio = new Google\Cloud\Speech\V1p1beta1\RecognitionAudio();
     *     $audio->setUri($uri);
     *     $response = $speechClient->recognize($config, $audio);
     * } finally {
     *     $speechClient->close();
     * }
     * ```
     *
     * @param RecognitionConfig $config       *Required* Provides information to the recognizer that specifies how to
     *                                        process the request.
     * @param RecognitionAudio  $audio        *Required* The audio data to be recognized.
     * @param array             $optionalArgs {
     *                                        Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Speech\V1p1beta1\RecognizeResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function recognize($config, $audio, array $optionalArgs = [])
    {
        $request = new RecognizeRequest();
        $request->setConfig($config);
        $request->setAudio($audio);

        return $this->startCall(
            'Recognize',
            RecognizeResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Performs asynchronous speech recognition: receive results via the
     * google.longrunning.Operations interface. Returns either an
     * `Operation.error` or an `Operation.response` which contains
     * a `LongRunningRecognizeResponse` message.
     *
     * Sample code:
     * ```
     * $speechClient = new Google\Cloud\Speech\V1p1beta1\SpeechClient();
     * try {
     *     $encoding = Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding::FLAC;
     *     $sampleRateHertz = 44100;
     *     $languageCode = 'en-US';
     *     $config = new Google\Cloud\Speech\V1p1beta1\RecognitionConfig();
     *     $config->setEncoding($encoding);
     *     $config->setSampleRateHertz($sampleRateHertz);
     *     $config->setLanguageCode($languageCode);
     *     $uri = 'gs://bucket_name/file_name.flac';
     *     $audio = new Google\Cloud\Speech\V1p1beta1\RecognitionAudio();
     *     $audio->setUri($uri);
     *     $operationResponse = $speechClient->longRunningRecognize($config, $audio);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $speechClient->longRunningRecognize($config, $audio);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $speechClient->resumeOperation($operationName, 'longRunningRecognize');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $speechClient->close();
     * }
     * ```
     *
     * @param RecognitionConfig $config       *Required* Provides information to the recognizer that specifies how to
     *                                        process the request.
     * @param RecognitionAudio  $audio        *Required* The audio data to be recognized.
     * @param array             $optionalArgs {
     *                                        Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function longRunningRecognize($config, $audio, array $optionalArgs = [])
    {
        $request = new LongRunningRecognizeRequest();
        $request->setConfig($config);
        $request->setAudio($audio);

        return $this->startOperationsCall(
            'LongRunningRecognize',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Performs bidirectional streaming speech recognition: receive results while
     * sending audio. This method is only available via the gRPC API (not REST).
     *
     * Sample code:
     * ```
     * $speechClient = new Google\Cloud\Speech\V1p1beta1\SpeechClient();
     * try {
     *     $request = new Google\Cloud\Speech\V1p1beta1\StreamingRecognizeRequest();
     *     // Write all requests to the server, then read all responses until the
     *     // stream is complete
     *     $requests = [$request];
     *     $stream = $speechClient->streamingRecognize();
     *     $stream->writeAll($requests);
     *     foreach ($stream->closeWriteAndReadAll() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Write requests individually, making read() calls if
     *     // required. Call closeWrite() once writes are complete, and read the
     *     // remaining responses from the server.
     *     $requests = [$request];
     *     $stream = $speechClient->streamingRecognize();
     *     foreach ($requests as $request) {
     *         $stream->write($request);
     *         // if required, read a single response from the stream
     *         $element = $stream->read();
     *         // doSomethingWith($element)
     *     }
     *     $stream->closeWrite();
     *     $element = $stream->read();
     *     while (!is_null($element)) {
     *         // doSomethingWith($element)
     *         $element = $stream->read();
     *     }
     * } finally {
     *     $speechClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\ApiCore\BidiStream
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function streamingRecognize(array $optionalArgs = [])
    {
        return $this->startCall(
            'StreamingRecognize',
            StreamingRecognizeResponse::class,
            $optionalArgs,
            null,
            Call::BIDI_STREAMING_CALL
        );
    }
}
