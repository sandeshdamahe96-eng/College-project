<?php
// Set headers to return JSON and allow cross-origin requests (for local development)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Define the path to your dataset
$datasetFile = 'dataset.json';

// Check if the dataset file exists
if (!file_exists($datasetFile)) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Dataset file not found.']);
    exit;
}

// Read and decode the dataset
$datasetJson = file_get_contents($datasetFile);
$dataset = json_decode($datasetJson, true);

// Get the requested model name from the URL (e.g., api.php?model=sycon)
$modelName = isset($_GET['model']) ? strtolower(trim($_GET['model'])) : '';

if (empty($modelName)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Model name not specified.']);
    exit;
}

// Check if the requested model exists in the dataset
if (array_key_exists($modelName, $dataset)) {
    // Success: return the model's data
    echo json_encode([
        'status' => 'success',
        'data' => $dataset[$modelName]
    ]);
} else {
    // Error: model not found
    http_response_code(404); // Not Found
    echo json_encode(['status' => 'error', 'message' => 'Model not found in dataset.']);
}

?>
