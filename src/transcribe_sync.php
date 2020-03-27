<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/speech/README.md
 */

// Include Google Cloud dependendencies using Composer
require_once __DIR__ . '/../vendor/autoload.php';

$argv='audio32KHz.raw';
//if (count($argv) != 2) {
   // return print("Usage: php transcribe_sync.php AUDIO_FILE\n");
//}
list($_, $audioFile) = $argv;

# [START speech_transcribe_sync]
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;


/*$ffmpeg = FFMpeg\FFMpeg::create([
        'ffmpeg.binaries'  => '/path/to/binaries', // the path to the FFMpeg binary
        'ffprobe.binaries' => '/path/to/ffprobe/binaries', // the path to the FFProbe binary
        'timeout' => 3600, // the timeout for the underlying process
        'ffmpeg.threads'   => 1,   // the number of threads that FFMpeg should use
], $logger);

// Open the video
$video = $ffmpeg->open( $full_video_path );

// Set the formats
$output_format = new FFMpeg\Format\Audio\Mp3(); // Here you choose your output format
$output_format->setAudioCodec("libmp3lame");

$video->save($output_format, '/path/to/output/file');/*




/** Uncomment and populate these variables in your code */
 $audioFile = 'audio32KHz.flac';

// change these variables if necessary
$encoding = AudioEncoding::FLAC;
$sampleRateHertz = 32000;
$languageCode = 'en-US';

// get contents of a file into a string
$content = file_get_contents($audioFile);

// set string as audio content
$audio = (new RecognitionAudio())
    ->setContent($content);

// set config
$config = (new RecognitionConfig())
    ->setEncoding($encoding)
    ->setSampleRateHertz($sampleRateHertz)
    ->setLanguageCode($languageCode);

// create the speech client
$client = new SpeechClient();

try {
    $response = $client->recognize($config, $audio);
    foreach ($response->getResults() as $result) {
        $alternatives = $result->getAlternatives();
        $mostLikely = $alternatives[0];
        $transcript = $mostLikely->getTranscript();
        $confidence = $mostLikely->getConfidence();
        //print_r($transcript);//exit;
       // printf('Transcript: %s' . PHP_EOL, $transcript);
        //printf('Confidence: %s' . PHP_EOL, $confidence);

        $file = "test.txt";
$txt = fopen($file, "w") or die("Unable to open file!");
fwrite($txt, $transcript);
fclose($txt);

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header("Content-Type: text/plain");
readfile($file);
    }
} finally {
    $client->close();
}
# [END speech_transcribe_sync]
