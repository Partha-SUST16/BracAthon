package bracathon.com.bracathon.teacher;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.Dialog;
import android.content.Intent;
import android.content.pm.PackageManager;
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
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import bracathon.com.bracathon.R;
import bracathon.com.bracathon.teacher.CustomAdapter;
import clarifai2.api.ClarifaiBuilder;
import clarifai2.api.ClarifaiClient;
import clarifai2.api.ClarifaiResponse;
import clarifai2.dto.input.ClarifaiInput;
import clarifai2.dto.model.ConceptModel;
import clarifai2.dto.model.output.ClarifaiOutput;
import clarifai2.dto.prediction.Concept;
//import com.clarifai.clarifai_android_sdk.core.Clarifai;

public class FaceActivity extends AppCompatActivity {

    private final int REQUEST_CODE_PERMISSION_READ_EXTERNAL_STORAGE = 102;
    private final int REQUEST_CODE_GALLERY = 103;
    private final int REQUEST_CODE_ATTACH_FILE = 104;
    private final int REQUEST_CODE_CAMERA = 105;

    private final String apiKey = "b5a9febc406247d0aa00bf8a488e8a6f";
    private Button buttonUpload;
    private Button buttonSubmit;
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

        buttonUpload = (Button)findViewById(R.id.button_main_upload);
        buttonSubmit = (Button)findViewById(R.id.button_main_submit);
//        adapter.setData(Collections.<Concept>emptyList());
        //listItems = new ArrayList<>();
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
                    new AsyncTask<Void, Void, ClarifaiResponse<List<ClarifaiOutput<Concept>>>>() {
                        @Override
                        protected ClarifaiResponse<List<ClarifaiOutput<Concept>>> doInBackground(Void... params) {

                            final ConceptModel generalModel = client.getModelByID("Human").executeSync().get().asConceptModel();

                            return generalModel.predict()
                                    .withInputs(ClarifaiInput.forImage("https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"))
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
                                    adapter = new CustomAdapter(predictions.get(0).data(), getApplicationContext());
                                    recyclerView.setAdapter(adapter);
                                    recyclerView.notify();
                                } catch (Exception e) {
                                    e.printStackTrace();
                                }
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
