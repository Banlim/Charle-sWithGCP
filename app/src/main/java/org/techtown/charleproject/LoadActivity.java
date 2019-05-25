package org.techtown.charleproject;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.ExifInterface;
import android.media.Image;
import android.os.Environment;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.ml.vision.FirebaseVision;
import com.google.firebase.ml.vision.common.FirebaseVisionImage;
import com.google.firebase.ml.vision.face.FirebaseVisionFace;
import com.google.firebase.ml.vision.face.FirebaseVisionFaceDetector;
import com.google.firebase.ml.vision.face.FirebaseVisionFaceDetectorOptions;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
//import java.sql.Date;
import java.io.InputStreamReader;
import java.text.ParseException;
import java.text.ParsePosition;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class LoadActivity extends AppCompatActivity {
    private ArrayList<File> resultFile; // 내부 저장소 이미지 파일 배열
    private ArrayList<File> updateImageFileArr; // 업데이트 이미지 파일 배열
   //private int ImageCount; // 내부 저장소 이미지 파일 개수

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_load);
        resultFile = new ArrayList<>();
        updateImageFileArr = new ArrayList<>();

        Button button = (Button) findViewById(R.id.return_button);
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

    }
    public void checkPermission(){
        // 마시멜로 버전 이후부터 무조건 사용자에게 권한 요청을 해야한다고 함.

        // 사용자에게 외부저장소 읽기 권한을 요청하는 함수
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.READ_EXTERNAL_STORAGE)!= PackageManager.PERMISSION_GRANTED) {
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,Manifest.permission.READ_EXTERNAL_STORAGE)) {

            } else {
                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                        1);
            }
        }

        // 사용자에게 외부저장소 쓰기 권한을 요청하는 함수
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE)!= PackageManager.PERMISSION_GRANTED) {
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,Manifest.permission.WRITE_EXTERNAL_STORAGE)) {

            } else {
                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE},
                        1);
            }
        }
    }
    private void cacheWrite(int ImageFileCount){
        String cacheFileName = "cacheFile.txt";
        String timeStamp = new SimpleDateFormat("yyyy-MM-dd").format(new Date());
        String ImageFileCountString = String.valueOf(ImageFileCount);
        Log.d("TimeStamp", timeStamp);
        Log.d("cacheFilePath", this.getFilesDir().getAbsolutePath());

        try{
            FileOutputStream os = openFileOutput(cacheFileName, Context.MODE_PRIVATE);
            os.write(timeStamp.getBytes());
            os.write("\n".getBytes());
            os.write(ImageFileCountString.getBytes());
            os.flush();
            os.close();
        }
        catch (IOException e){
            e.printStackTrace();
        }
    }
    private String[] cacheRead(String cacheFileName){
        // cacheReadFile[0] : timeStamp
        // cacheReadFile[1] : FileCount
        String[] cacheReadFile = new String[2];

        try{
            FileInputStream is = openFileInput(cacheFileName);
            BufferedReader buffer = new BufferedReader(new InputStreamReader(is));
            cacheReadFile[0] = buffer.readLine();
            cacheReadFile[1] = buffer.readLine();
            buffer.close();
        }
        catch (IOException e){
            e.printStackTrace();
        }
        Log.d("cacheTimeStamp", cacheReadFile[0]);
        Log.d("cacheFileCount", cacheReadFile[1]);
        
        return cacheReadFile;
    }
    public void init(){
        checkPermission();
        // 권한이 허락 되면, 내부저장소에 미리 저장된 캐시 파일을 확인한다.
        // 그 캐시 파일을 열어서 이전까지 저장된 이미지 파일 개수와 날짜를 불러온다.
        // 만약 캐시 파일이 없다면, firstImagePathArrayCount 함수를 호출하고, 캐시파일을 생성한다.
        // first~~ 함수의 결과값을 통해 personSeparate 함수를 호출하여 인물로 분류된 이미지를 모델로 전송한다.
        // 캐시 파일이 있다면, 캐시 파일에 저장된 이미지 파일 개수를 비교하는 updateCheckImagePathArray 함수를 호출한다.
        // update 해야한다고 리턴값이 나오면, updateImagePathArray 함수를 호출한다.
        // update~~함수의 결과값을 통해 personSeparate 함수를 호출하여 업데이트 해야할 이미지 파일들만 모델로 전송한다.

        // 요런 내용을 곧 코드로 짤 계획이다.
        // 다 작성하면 주석 지워야징
    }
    public static boolean checkExternalAvailable(){

        // 외부저장소 사용할 수 있는지 확인하는 함수
        // 근데 쓸지 안 쓸지는 잘 모르겠음

        String state = Environment.getExternalStorageState();
        if(Environment.MEDIA_MOUNTED.equals(state)){
            return true;
        }
        return false;
    }
    public static boolean checkExternalWriteable(){

        // 외부저장소에 write 할 수 있는지 확인하는 함수
        // 근데 쓸지 안 쓸지는 잘 모르겠음.
        String state = Environment.getExternalStorageState();
        if(Environment.MEDIA_MOUNTED.equals(state)){
            if(Environment.MEDIA_MOUNTED_READ_ONLY.equals(state)){
                return false;
            }
            else{
                return true;
            }
        }
        return false;
    }
    public int firstImagePathArrayCount(String path){

        // 앱 첫 실행 시 모든 이미지 파일을 업로드 하기 위한 함수

        File imageFile = new File(path);
        File [] imageFiles = imageFile.listFiles();
        File innerFile;
        String innerPath;
        int temp = 0;
        int imageCount = 0;

        for(int i = 0; i < imageFiles.length; i++){
            if(imageFiles[i].isDirectory()){
                Log.d("FirstDirectory", imageFiles[i].getName());
                innerPath = imageFiles[i].getAbsolutePath();
                temp = firstImagePathArrayCount(innerPath);
                imageCount += temp;
                Log.d("innerPath", innerPath);
            }
            else{
                if(imageFiles[i].getName().endsWith("jpg") || imageFiles[i].getName().endsWith("png")){
                    Log.d("FirstFiles", imageFiles[i].getName());
                    resultFile.add(imageFiles[i]);
                }
                imageCount++;
            }
        }
        Log.d("imageCount", String.valueOf(imageCount));
        return imageCount;
    }
    public boolean updateCheckImagePathArray(String path, int prevCount){

        // 현재 이미지 파일을 업데이트 해야하는지 말아야하는지 판단하는 함수
        // 이미지 개수로 비교

        String imageFilePath = path;
        File imageFile = new File(imageFilePath);
        File [] imageFiles = imageFile.listFiles();
        String innerPath;
        File innerFile;
        int imageCount = 0;
        boolean TF = false;

        for(int i = 0; i < imageFiles.length; i++){
            if(imageFiles[i].isDirectory()){
                innerPath = imageFiles[i].getAbsolutePath();
                innerFile = new File(innerPath);
                if(!innerFile.isDirectory()){
                    Log.d("updateCheckCount", String.valueOf(innerFile.listFiles().length));
                    imageCount += innerFile.listFiles().length;
                }
            }
        }
        if(imageCount > prevCount){
            TF = true;
        }

        return TF;
    }
    public ArrayList<File> updateImagePathArray(String path, Date prevDate){

        // 최근 이미지 파일들만 업데이트 하는 함수

        String imagePath = path;
        File imageFIle = new File(imagePath);
        File[] imageFiles = imageFIle.listFiles();
        String innerPath;
        File innerFile;
        try{
            // ExifInterface -> 이미지가 가지고 있는 메타데이터 정보를 가져올 수 잇음.
            ExifInterface exif;
            for(int i = 0; i < imageFiles.length; i++){
                if(imageFiles[i].isDirectory()){
                    innerPath = imageFiles[i].getAbsolutePath();
                    innerFile = new File(innerPath);
                    updateImagePathArray(innerPath, prevDate);
                }
                else{
                    exif = new ExifInterface(imageFiles[i].getAbsolutePath());
                    Date newDate = stringToDate(ExifInterface.TAG_DATETIME);

                    // 최신 사진만 업데이트 하기 위해 날짜 비교
                    if(newDate.after(prevDate) && (imageFiles[i].getName().endsWith("jpg") || imageFiles[i].getName().endsWith("png"))){
                        updateImageFileArr.add(imageFiles[i]);
                        Log.d("updateFile", imageFiles[i].getName());
                    }
                }
            }
        }
        catch(IOException e){
            e.printStackTrace();
        } catch (ParseException pe) {
            pe.printStackTrace();
        }
        return updateImageFileArr;
    }
    private Date stringToDate(String date) throws ParseException {
        if(date == null)
            return null;
        SimpleDateFormat transFormat = new SimpleDateFormat("yyyy-MM-dd");
        Date to = transFormat.parse(date);

        return to;
    }
    public void personSeparate(ArrayList<File> imageFileArray){
        // 인물인지 아닌지 분류하는 함수
        // Firebase -> ML Kit face Detction 이용
        FirebaseVisionFaceDetectorOptions options =
                new FirebaseVisionFaceDetectorOptions.Builder()
                .setLandmarkMode(FirebaseVisionFaceDetectorOptions.ALL_LANDMARKS)
                .setClassificationMode(FirebaseVisionFaceDetectorOptions.ALL_CLASSIFICATIONS)
                .setMinFaceSize(0.2f)
                .build();

        FirebaseVisionFaceDetector detector = FirebaseVision.getInstance().getVisionFaceDetector();
        Bitmap bitmap;
        FirebaseVisionImage firebaseVisionImage;
        for(int i = 0; i < imageFileArray.size(); i++){
            bitmap = BitmapFactory.decodeFile(imageFileArray.get(i).getAbsolutePath());
            firebaseVisionImage = FirebaseVisionImage.fromBitmap(bitmap);
            detector.detectInImage(firebaseVisionImage).addOnSuccessListener(this,
                    new OnSuccessListener<List<FirebaseVisionFace>>() {
                        @Override
                        public void onSuccess(List<FirebaseVisionFace> firebaseVisionFaces) {
                            for(FirebaseVisionFace face : firebaseVisionFaces){
                                if((face.getRightEyeOpenProbability() != FirebaseVisionFace.UNCOMPUTED_PROBABILITY)
                                || (face.getLeftEyeOpenProbability() != FirebaseVisionFace.UNCOMPUTED_PROBABILITY)){
                                    Log.d("firebaseVisionFace", "Success");
                                    // 모델로 이미지 전송하는 코드 작성하면 된당
                                }
                            }
                        }
                    })
                    .addOnFailureListener(this,
                            new OnFailureListener() {
                                @Override
                                public void onFailure(@NonNull Exception e) {
                                    Log.e("firebaseVisionFace", "failure");
                                }
                            });
        }
    }
}
