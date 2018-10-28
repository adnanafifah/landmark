# image-food-calori-demo
This project is entirely based on AxelAli project. But there are still things that need to change and requires a lot of time to configure it. So, I recreate his project in order to make the process simpler. Original source:

	https://github.com/AxelAli/Tensorflow-Image-Classification

PREREQUISITE:
1. 	Install required software:
	
		-XAMPP (or any tools to do localhost)
		-install python 3.6.1 64 bit. (3.7,3.60 doesn't work)
		-LightShot (*Optional: good snipping tool alternative to save Google Image in lazy way. Make sure save the image in jpg format.)
		-Microsoft Visual C++ 2015 Redistributable Update 3 (install if required step in PREREQUISITE doesn't work)

2.	Run cmd command:

		python -m pip install --upgrade pip
		pip3 install -U pip virtualenv
		pip install tensorflow --upgrade
		pip install image
	
	
	*Additional command if doesn't work:
	
		pip install ipykernel
		pip install tensorflow_hub)
	
3.	Test the tensorflow whether it is work using cmd:
		
		  python -c "import tensorflow as tf; print(tf.VERSION)"
	
	*If didn't work, locate the python directory and install appropriate version of tensorflow whl using CMD:
	
		  cd C:\Users\<your pc name>\AppData\Local\Programs\Python\Python36
		  pip install https://storage.googleapis.com/tensorflow/linux/cpu/tensorflow-1.11.0-cp36-cp36m-linux_x86_64.whl

4.	Download this whole project:
		  https://github.com/muhaafidz/image-food-calori-demo
		
5.	Run the website through localhost. (The prediction won't worked since there is no trained model yet in the project folder)
	
  
TRAIN THE IMAGE: 

1. 	Download a collection of images at any source.
2.  	Save the image at "..\tensorflow\data\<appropriate group image folder>\
   	*Make sure that save it in jpg format. And each of image group need to have at least 21 images and above.
    	*You also can create a new folder to add a new image group.
	
2.	locate tensorflow folder location in CMD. eg:
      
		cd C:\xampp\htdocs\<your project folder>\tensorflow
	
	  retrain the image by executing this command using CMD:
	    
		python retrain.py --bottleneck_dir=./output/bottlenecks --how_many_training_steps 300  --model_dir=./output/inception --output_graph=./output/retrained_graph.pb --output_labels=./output/retrained_labels.txt --image_dir ./data/

	
TEST THE WEBSITE:

1.	Open the website through localhost.

2.	Try to upload some image. Enjoy!
