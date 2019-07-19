package com.example.clarifai_facerecognition;

import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

import clarifai2.api.ClarifaiBuilder;
import clarifai2.api.ClarifaiClient;
import clarifai2.api.ClarifaiResponse;
import clarifai2.dto.input.ClarifaiInput;
import clarifai2.dto.model.ConceptModel;
import clarifai2.dto.model.output.ClarifaiOutput;
import clarifai2.dto.prediction.Concept;
//import com.clarifai.clarifai_android_sdk.core.Clarifai;

public class MainActivity extends AppCompatActivity {

    private final String apiKey = "b5a9febc406247d0aa00bf8a488e8a6f";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        final TextView text = (TextView)findViewById(R.id.text__id);
        final ClarifaiClient client = new ClarifaiBuilder("b5a9febc406247d0aa00bf8a488e8a6f").buildSync();

        new AsyncTask<Void, Void, ClarifaiResponse<List<ClarifaiOutput<Concept>>>>() {
            @Override protected ClarifaiResponse<List<ClarifaiOutput<Concept>>> doInBackground(Void... params) {

                final ConceptModel generalModel = client.getModelByID("Human").executeSync().get().asConceptModel();

                return generalModel.predict()
                        .withInputs(ClarifaiInput.forImage("https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"))
                        .executeSync();

            }

            @Override protected void onPostExecute(ClarifaiResponse<List<ClarifaiOutput<Concept>>> response) {



                if (response.isSuccessful()) {
                    Log.i("brac", response.toString());
                }
                final List<ClarifaiOutput<Concept>> predictions = response.get();
                if (!predictions.isEmpty()) {
                    Log.i("brac", predictions.toString());
                    String data = String.valueOf(predictions.get(0).data());
                    text.setText(data);
                    }

                Log.i("nihal", predictions.get(0).data().toString());
//                imageView.setImageBitmap(BitmapFactory.decodeByteArray(imageBytes, 0, imageBytes.length));
            }
        }.execute();

    }
}
