package bracathon.com.bracathon.teacher;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.FileProvider;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;

import bracathon.com.bracathon.Constant;
import bracathon.com.bracathon.R;
import bracathon.com.bracathon.RequestHandler;
import bracathon.com.bracathon.teacher.CustomAdapter;
import bracathon.com.bracathon.teacher.v2.ClarifaiUtil;
import clarifai2.api.ClarifaiBuilder;
import clarifai2.api.ClarifaiClient;
import clarifai2.api.ClarifaiResponse;
import clarifai2.dto.input.ClarifaiImage;
import clarifai2.dto.input.ClarifaiInput;
import clarifai2.dto.model.ConceptModel;
import clarifai2.dto.model.output.ClarifaiOutput;
import clarifai2.dto.prediction.Concept;
import me.ithebk.barchart.BarChartModel;
//import com.clarifai.clarifai_android_sdk.core.Clarifai;

public class FaceActivity extends AppCompatActivity {
    private ProgressDialog progressDialog;

    private final int REQUEST_CODE_PERMISSION_READ_EXTERNAL_STORAGE = 102;
    private final int REQUEST_CODE_GALLERY = 103;
    private final int REQUEST_CODE_ATTACH_FILE = 104;
    private final int REQUEST_CODE_CAMERA = 105;

    private final String apiKey = "b5a9febc406247d0aa00bf8a488e8a6f";
    private Button buttonUpload;
    private Button buttonSubmit,addTodb;
    private TextView text;
    private Dialog dialogAttachment;
    private String folderPath;
    private String fileName;
    private byte[] imageBytesSelectedResult;

    //private final String apiKey = "b5a9febc406247d0aa00bf8a488e8a6f";
    RecyclerView recyclerView ;

    CustomAdapter adapter;
    @SuppressLint("StaticFieldLeak")

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_face);
        Data.attendence = "";


        addTodb = (Button) findViewById(R.id.button_add_todb);

        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Uploading...");

        buttonUpload = (Button)findViewById(R.id.button_main_upload);
        buttonSubmit = (Button)findViewById(R.id.button_main_submit);
//        adapter.setData(Collections.<Concept>emptyList());
        recyclerView = (RecyclerView) findViewById(R.id.recycler_view);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        final TextView text = (TextView)findViewById(R.id.text__id);
        final ClarifaiClient client = new ClarifaiBuilder("b5a9febc406247d0aa00bf8a488e8a6f").buildSync();
        buttonUpload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                    if (ActivityCompat.checkSelfPermission(FaceActivity.this, Manifest.permission.READ_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED) {
                        Toast.makeText(getApplicationContext(),"Permission not found",Toast.LENGTH_SHORT).show();
                        requestPermissions(new String[]{Manifest.permission.READ_EXTERNAL_STORAGE}, REQUEST_CODE_PERMISSION_READ_EXTERNAL_STORAGE);
                    } else {
                        showAttachmentDialog();
                    }
                } else {
                    showAttachmentDialog();
                }
            }
        });

        buttonSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    progressDialog.show();
                    Data.attendence = "";
                    new AsyncTask<Void, Void, ClarifaiResponse<List<ClarifaiOutput<Concept>>>>() {
                        @Override
                        protected ClarifaiResponse<List<ClarifaiOutput<Concept>>> doInBackground(Void... params) {

                            final ConceptModel generalModel = client.getModelByID("Human").executeSync().get().asConceptModel();
                            Log.i("hey", imageBytesSelectedResult.toString());
                            return generalModel.predict()
                                    //.withInputs(ClarifaiInput.forImage("https://scontent.fdac14-1.fna.fbcdn.net/v/t31.0-8/31184649_1661122980602803_3285019704872136481_o.jpg?_nc_cat=109&_nc_oc=AQnBMU84ZR207HaOT2OyTZTxC56PQfhJhksf8eoJD6-4G9hgwwEUNtUV_1X5OChxMPM&_nc_ht=scontent.fdac14-1.fna&oh=ed08696ac21a83d345d836323d41b766&oe=5DB6E8D0"))
                                    .withInputs(ClarifaiInput.forImage(ClarifaiImage.of(imageBytesSelectedResult)))
                                    .executeSync();

                        }

                        @Override
                        protected void onPostExecute(ClarifaiResponse<List<ClarifaiOutput<Concept>>> response) {

                            HashMap hashMap = new HashMap();
                            if (response.isSuccessful()) {
                                Log.i("brac", response.toString());
                            }
                            final List<ClarifaiOutput<Concept>> predictions = response.get();
                            if (!predictions.isEmpty()) {
                                // Log.i("brac", predictions.toString());
                                String data = String.valueOf(predictions.get(0).data());
                                text.setText(data);
                                String jsonData = String.valueOf(predictions);
                                Log.d("brac", data);
                                try {
                                    progressDialog.dismiss();
                                    adapter = new CustomAdapter(predictions.get(0).data(), getApplicationContext());
                                    recyclerView.setAdapter(adapter);
                                    recyclerView.notify();

                                } catch (Exception e) {
                                    e.printStackTrace();
                                }
                                Log.i("jarin", predictions.get(0).data().toString());
                                //text.setText(data);
                            }

                            Log.i("jarin", "HI"+Data.attendence);
//                imageView.setImageBitmap(BitmapFactory.decodeByteArray(imageBytes, 0, imageBytes.length));

                        }
                    }.execute();
                } catch (Exception e) {
                    e.printStackTrace();
                    Toast.makeText(FaceActivity.this, "Network problem", Toast.LENGTH_SHORT).show();
                }
            }
        });

        addTodb.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                call();
            }
        });


    }
    private void call(){
        Log.d("Check123",Data.attendence);
        StringRequest stringRequest = new StringRequest(
                Request.Method.GET,
                Constant.attendence+"?school="+Integer.parseInt(Data.school_id)+"&name="+Data.attendence,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        // progressDialog.dismiss();
                        try {
                            Log.d("Check","["+response+"]");
                            JSONObject obj = new JSONObject(response);

                        } catch (JSONException e) {
                            Log.d("Error","["+e.getMessage()+"]");
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        //progressDialog.dismiss();

                        Toast.makeText(
                                getApplicationContext(),
                                "["+error.getMessage()+"]",
                                Toast.LENGTH_LONG
                        ).show();
                        Log.d("Error","["+error.getMessage()+"]");
                    }
                }
        ) {
            @Override
            protected Response<String> parseNetworkResponse(NetworkResponse response) {
                if (response.headers == null)
                {
                    // cant just set a new empty map because the member is final.
                    response = new NetworkResponse(
                            response.statusCode,
                            response.data,
                            Collections.<String, String>emptyMap(), // this is the important line, set an empty but non-null map.
                            response.notModified,
                            response.networkTimeMs);


                }

                return super.parseNetworkResponse(response);
            }

        };

        RequestHandler.getInstance(this).addToRequestQueue(stringRequest);
    }


    @Override
    public void onActivityResult(int requestCode, int resultCode,
                                 Intent resultData) {
        // The ACTION_OPEN_DOCUMENT intent was sent with the request code
        // READ_REQUEST_CODE. If the request code seen here doesn't match, it's the
        // response to some other intent, and the code below shouldn't run at all.
        if (requestCode == REQUEST_CODE_GALLERY && resultCode == RESULT_OK) {

            try {
                Uri uri = null;
                if (resultData != null) {
                    final byte[] imageBytes = ClarifaiUtil.retrieveSelectedImage(this, resultData);
                    imageBytesSelectedResult = imageBytes;
                }
            } catch (Exception e) {

                e.printStackTrace();
            }

        }  else if (requestCode == REQUEST_CODE_CAMERA && resultCode == RESULT_OK) {

            try {
                File folder = new File(folderPath);

                if (!folder.exists()) {
                    folder.mkdirs();
                }
                File prescriptionImage = new File(folder, fileName);
                String imageFilePath = prescriptionImage.getPath();

                String filepath = imageFilePath;
                File imagefile = new File(filepath);
                FileInputStream fis = null;
                try {
                    fis = new FileInputStream(imagefile);
                } catch (FileNotFoundException e) {
                    e.printStackTrace();
                }

                Bitmap bm = BitmapFactory.decodeStream(fis);
                ByteArrayOutputStream baos = new ByteArrayOutputStream();
                bm.compress(Bitmap.CompressFormat.JPEG, 100, baos);
                byte[] b = baos.toByteArray();
                imageBytesSelectedResult = b;

            } catch (Exception e) {

                e.printStackTrace();

            }
        }
    }


    private void showAttachmentDialog() {

        dialogAttachment = new Dialog(this);
        dialogAttachment.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialogAttachment.setContentView(R.layout.layout_dialog_attachment);
        dialogAttachment.setCancelable(true);
        dialogAttachment.setCanceledOnTouchOutside(true);

        // set the custom dialog components - text, image and button
        ImageView imageViewCancel = (ImageView) dialogAttachment.findViewById(R.id.imageView_cancel);
        imageViewCancel.setImageResource(R.drawable.icon_cross);
        imageViewCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                dialogAttachment.dismiss();
            }
        });

        LinearLayout linearLayoutButtonAttachmentGallery = (LinearLayout) dialogAttachment.findViewById(R.id.linearLayout_button_attachment_gallery);
        linearLayoutButtonAttachmentGallery.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialogAttachment.dismiss();

                startGalleryIntent();
            }
        });

        LinearLayout linearLayoutButtonAttachmentCamera = (LinearLayout) dialogAttachment.findViewById(R.id.linearLayout_button_attachment_camera);
        linearLayoutButtonAttachmentCamera.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialogAttachment.dismiss();

                startCameraIntent();
            }
        });
        dialogAttachment.show();
    }

    private void startGalleryIntent() {
        if (ActivityCompat.checkSelfPermission(this,
                android.Manifest.permission.READ_EXTERNAL_STORAGE) !=
                PackageManager.PERMISSION_GRANTED) {
            Toast.makeText(getApplicationContext(),"We need permission to select image from gallery",Toast.LENGTH_SHORT).show();
            return;
        }

        Intent intent = new Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
        startActivityForResult(intent, REQUEST_CODE_GALLERY);
    }

    private void startCameraIntent() {
        folderPath = Environment.getExternalStorageDirectory().getPath() + "/Clarifai/images/";
        fileName = System.currentTimeMillis() + ".jpg";
        File folder = new File(folderPath);

        if (!folder.exists()) {
            folder.mkdirs();
        }

        File imageFile = new File(folderPath, fileName);
        Uri imageUri = FileProvider.getUriForFile(getApplicationContext(),
                this.getApplicationContext().getPackageName() + ".provider", imageFile);

        Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        intent.putExtra(MediaStore.EXTRA_OUTPUT, imageUri);
        intent.addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION);
        startActivityForResult(intent, REQUEST_CODE_CAMERA);
    }
}
